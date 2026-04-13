<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function ($middleware) {

        // =========================
        // CSRF
        // =========================
        $middleware->validateCsrfTokens(except: [
            'login',
        ]);

        // =========================
        // FORCE MIDDLEWARE
        // =========================
        $middleware->alias([
            'force.app' => \App\Http\Middleware\ForceFromApp::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
