<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\TrackVisitor::class,
        ]);

        $middleware->validateCsrfTokens(except: [
            'user/send-otp',
            'user/verify-otp',
            'user/send_otp',
            'user/verify_otp',
            'user/report-request',
            'citizen/send-otp',
            'citizen/verify-otp',
            'report-request',
        ]);

        $middleware->redirectTo(
            guests: function (Request $request) {
                if ($request->is('vehicle*')) {
                    return route('vehicle.login');
                }
                if ($request->is('admin*')) {
                    return route('admin.login');
                }
                return route('user.login');
            },
            users: function (Request $request) {
                if ($request->is('vehicle*')) {
                    return route('vehicle.dashboard');
                }
                if ($request->is('admin*')) {
                    return route('admin.dashboard');
                }
                return route('user.dashboard');
            }
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->expectsJson() || $request->ajax() || $request->is('api/*') || $request->is('user/*') || $request->is('citizen/*'),
        );
    })->create();
