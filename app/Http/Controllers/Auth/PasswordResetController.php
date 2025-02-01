<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class PasswordResetController extends Controller
{
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    public function verify(Request $request)
{
    $validator = Validator::make($request->all(), [
        'phone_number' => ['required', 'string', 'regex:/^(09|\+639)\d{9}$/'],
        'otp_verified' => ['required', 'string', 'in:true'],
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    $phoneNumber = preg_replace('/[^0-9]/', '', $request->phone_number);
    
    // Search for both 09 and +639 formats
    $user = User::where('phone_number', '09' . substr($phoneNumber, -9))
                ->orWhere('phone_number', '+639' . substr($phoneNumber, -9))
                ->orWhere('phone_number', '9' . substr($phoneNumber, -9))
                ->first();

    \Log::info('Phone lookup:', ['input' => $request->phone_number, 'formatted' => $phoneNumber]);
    
    if (!$user) {
        return response()->json([
            'success' => false,
            'errors' => ['phone_number' => ['No account found with this phone number.']]
        ], 404);
    }

    return response()->json(['success' => true]);
}

public function reset(Request $request)
{
    $validator = Validator::make($request->all(), [
        'phone_number' => ['required', 'string', 'regex:/^(09|\+639)\d{9}$/'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
        'otp_verified' => ['required', 'string', 'in:true'],
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    $phoneNumber = preg_replace('/[^0-9]/', '', $request->phone_number);
    
    $user = User::where('phone_number', '09' . substr($phoneNumber, -9))
                ->orWhere('phone_number', '+639' . substr($phoneNumber, -9))
                ->orWhere('phone_number', '9' . substr($phoneNumber, -9))
                ->first();

    if (!$user) {
        \Log::error('User not found during password reset', ['phone' => $phoneNumber]);
        return response()->json([
            'success' => false,
            'errors' => ['phone_number' => ['User not found.']]
        ], 404);
    }

    try {
        $user->forceFill([
            'password' => Hash::make($request->password)
        ])->save();

        \Log::info('Password reset successful', ['user_id' => $user->id]);
        
        // For API requests
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Password reset successful'
            ]);
        }
        return redirect()->route('login', ['status' => 'password-reset']);



        // For web requests
    } catch (\Exception $e) {
        \Log::error('Password reset failed', [
            'error' => $e->getMessage(),
            'user_id' => $user->id
        ]);
        
        return response()->json([
            'success' => false,
            'errors' => ['general' => ['Failed to reset password']]
        ], 500);
    }
}

    private function formatPhoneNumber($phoneNumber)
    {
        $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);
        
        if (substr($phoneNumber, 0, 2) === '09') {
            return '+639' . substr($phoneNumber, 2);
        }
        
        return '+' . $phoneNumber;
    }
}