<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Check if user is authenticated and if their role is among the allowed roles
        if ($request->user() && !in_array($request->user()->role, $roles)) {
            return redirect($this->getRedirectUrl($request->user()->role));
        }

        return $next($request);
    }

    private function getRedirectUrl(string $role): string
    {
        return match ($role) {
            'superadmin' => 'superadmin/dashboard',
            'admin' => '/admin/dashboard',
            'tmu' => '/tmu/dashboard',
            default => '/user/dashboard',
        };
    }
}
