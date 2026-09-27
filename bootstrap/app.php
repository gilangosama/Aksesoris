<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Set language based on query parameter or session
        $middleware->web(append: [
            \App\Http\Middleware\SetLanguage::class,
        ]);

        // Exclude Midtrans webhook from CSRF verification
        $middleware->validateCsrfTokens(except: [
            'payment/notification',
            'auth/google/callback',
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
