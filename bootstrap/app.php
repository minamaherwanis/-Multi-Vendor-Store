<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',

        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'checkUserType' => \App\Http\Middleware\CheckUserType::class,
        ]);

        // ✅web.php ميدل وير بيشتغل فقط على 
        $middleware->web([
            \App\Http\Middleware\UpdateUserLastActiveAt::class,
            \App\Http\Middleware\MarkNotificationAsRead::class,
        ]);
        // ⬅️API ميدل وير خاص بالـ 
        $middleware->api([
            \App\Http\Middleware\CheckApiToken::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
