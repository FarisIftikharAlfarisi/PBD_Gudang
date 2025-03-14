<?php

use App\Http\Middleware\CheckJabatan;
use App\Http\Middleware\KaryawanAuth;
use Illuminate\Foundation\Application;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //middleware custom
        $middleware->group('web', [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            
        ]);

        // Alias untuk penggunaan middleware di route
        $middleware->alias(['karyawan_auth' => App\Http\Middleware\KaryawanAuth::class]);
        $middleware->alias(['cek_role' => App\Http\Middleware\CheckJabatan::class]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
