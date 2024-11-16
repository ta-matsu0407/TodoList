<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    // public function boot(): void
    // {
    //     Vite::prefetch(concurrency: 3);
    // }

    public function boot()
    {
        if (request()->is('student*')) {
            config(['session.cookie' => config('session.cookie_student')]);
        } elseif (request()->is('admin*')) {
            config(['session.cookie' => config('session.cookie_admin')]);
            } else {
            config(['session.cookie' => config('session.cookie')]);
        }
    }
}
