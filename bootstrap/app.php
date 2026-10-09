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

        // Trust proxy seperti ngrok
        $middleware->trustProxies(at: '*');

        // Alias middleware peran admin untuk grup route admin
        // Alias tamu404: pengganti auth agar tamu dapat 404 (anti bocor URL)
        $middleware->alias([
            'admin' => \App\Http\Middleware\IsAdmin::class,
            'tamu404' => \App\Http\Middleware\Tamu404::class,
            'nonadmin' => \App\Http\Middleware\NonAdmin::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();