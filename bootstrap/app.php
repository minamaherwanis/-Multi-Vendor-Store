<?php
namespace App\Http\Middleware;
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
        'checkUserType'          => \App\Http\Middleware\CheckUserType::class,
        'localize'               => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
        'localizationRedirect'   => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
        'localeSessionRedirect'  => \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
        'localeCookieRedirect'   => \Mcamara\LaravelLocalization\Middleware\LocaleCookieRedirect::class,
        'localeViewPath'         => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class,
        'super_admin' => \App\Http\Middleware\SuperAdminMiddleware::class,
    ]);

    // ✅ middleware خاص بالـ web
    $middleware->web([
        \App\Http\Middleware\UpdateUserLastActiveAt::class,
        \App\Http\Middleware\MarkNotificationAsRead::class,
    ]);

    // ⬅️ middleware خاص بالـ API
    $middleware->api([
        \App\Http\Middleware\CheckApiToken::class,
    ]);
})
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
