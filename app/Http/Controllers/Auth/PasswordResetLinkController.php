<?php
// app/Http/Controllers/Auth/PasswordResetLinkController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PasswordResetLinkController extends Controller
{
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'phone_number' => ['required', 'string'],
            'otp_verified' => ['required', 'in:true'],
        ]);

        $user = User::where('phone_number', $request->phone_number)->first();

        if (!$user) {
            return back()->withErrors(['phone_number' => __('We cannot find a user with that phone number.')]);
        }

        // Generate a unique token
        $token = Str::random(64);
        
        // Store the token
        DB::table('password_reset_tokens')->updateOrInsert(
            ['phone_number' => $request->phone_number],
            [
                'token' => $token,
                'created_at' => now()
            ]
        );

        return redirect()->route('password.reset', ['token' => $token, 'phone_number' => $request->phone_number])
            ->with('status', 'Phone number verified. Please set your new password.');
    }
}
