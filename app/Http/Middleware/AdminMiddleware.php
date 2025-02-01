<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    // /**
    //  * Handle an incoming request.
    //  *
    //  * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
    //  */
    // public function handle(Request $request, Closure $next): Response
    // {
    //     // Check if user is authenticated
    //     if (!Auth::check()) {
    //         return redirect()->route('login')->with('error', 'Please login first');
    //     }

    //     // Check if user is an admin
    //     if (!Auth::user()->is_admin) {
    //         // Redirect to unauthorized page or homepage
    //         return redirect()->route('home')->with('error', 'You do not have admin access');
    //     }

    //     return $next($request);
    // }

    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            return $next($request);
        }

        return redirect('/')->with('error', 'Unauthorized access');
    }
}