<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


// return Application::configure(basePath: dirname(__DIR__))
//     ->withRouting(
//         web: __DIR__.'/../routes/web.php',
//         commands: __DIR__.'/../routes/console.php',
//         health: '/up',
//     )
//     ->withMiddleware(function (Middleware $middleware) {
//         $middleware->web(append: [
//             \App\Http\Middleware\HandleInertiaRequests::class,
//             \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
//         ]);

//         //
//     })
//     ->withExceptions(function (Exceptions $exceptions) {
//         //
//     })->create();

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            // Adminルートをプレフィックス付きでグループ化
            Route::middleware('web')
                ->prefix('admin')
                ->name('admin.')
                ->group(__DIR__ . '/../routes/admin.php');

            // Studentルートをプレフィックス付きでグループ化
            Route::middleware('web')
                ->prefix('student')
                ->name('student.')
                ->group(__DIR__ . '/../routes/student.php');
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectGuestsTo(function(Request $request){
        if(request()->routeIs('student*')){
            return $request->expectsJson() ? nul : route('student.login');
        } elseif(request()->routeIs('admin*')){
            return $request->expectsJson() ? nul : route('admin.login');
        } else {
            return $request->expectsJson() ? nul : route('login');
        }
        });
        })

    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
