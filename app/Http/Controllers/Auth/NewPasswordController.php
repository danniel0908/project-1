<?php
// app/Http/Controllers/Auth/NewPasswordController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class NewPasswordController extends Controller
{
    public function create(Request $request): View
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'phone_number' => ['required'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Verify token
        $tokenData = DB::table('password_reset_tokens')
            ->where('phone_number', $request->phone_number)
            ->where('token', $request->token)
            ->first();

        if (!$tokenData) {
            return back()->withErrors(['email' => __('Invalid token.')]);
        }

        $user = User::where('phone_number', $request->phone_number)->first();

        if (!$user) {
            return back()->withErrors(['phone_number' => __('User not found.')]);
        }

        // Reset password
        $user->forceFill([
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(60),
        ])->save();

        // Delete used token
        DB::table('password_reset_tokens')
            ->where('phone_number', $request->phone_number)
            ->delete();

        event(new PasswordReset($user));

        return redirect()->route('login')
            ->with('status', __('Password has been reset successfully.'));
    }
}