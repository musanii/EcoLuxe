<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Routing\Exceptions\InvalidSignatureException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->validateCsrfTokens(except: [
        'stripe/webhook',
         'api/v1/payments/mpesa/*', // Using a wildcard covers all sub-routes
        'api/v1/payments/mpesa/callback',
    ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Catch the expired/invalid signed URL error
        $exceptions->render(function (InvalidSignatureException $e) {
            return redirect()->route('booking.expired')
                ->with('error', 'Your recovery link has expired. Please start a new reservation.');
        });
    })->create();
