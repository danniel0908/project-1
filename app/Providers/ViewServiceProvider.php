<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                $userInfo = [
                    'fullName' => trim($user->first_name . ' ' . 
                                    ($user->middle_name ? $user->middle_name . ' ' : '') . 
                                    $user->last_name . ' ' .
                                    ($user->suffix ?? '')),
                    'applicantType' => ucfirst($user->applicant_type ?? 'N/A'),
                    'role' => ucfirst($user->role),
                    'firstName' => $user->first_name,
                    'lastName' => $user->last_name,
                    'middle_name' => $user->middle_name,
                    'suffix' => $user->suffix,
                    'phone_number' => $user->phone_number
                ];
                $view->with('userInfo', $userInfo);
            }
        });
    }
}