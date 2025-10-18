<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
require_once app_path('Helpers/GlobalHelpers.php');

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
    public function boot()
    {
        if (function_exists('getPendingWithdrawals') && function_exists('getPendingWithdrawalsCount')) {
            View::share('pendingWithdrawals', getPendingWithdrawals());
            View::share('pendingWithdrawalsCount', getPendingWithdrawalsCount());
        }
    }
}