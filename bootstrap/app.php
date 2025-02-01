<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\Role;
use App\Http\Middleware\LanguageMiddleware;  // Add this line

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register global middleware
        $middleware->web([
            LanguageMiddleware::class,  // Add this line
        ]);

        // Register middleware aliases
        $middleware->alias([
            'role' => \App\Http\Middleware\Role::class,
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'language' => \App\Http\Middleware\LanguageMiddleware::class,  // Optional: add alias
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();