<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;

require_once app_path('Helpers/GlobalHelpers.php');

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // 1) Jangan jalan saat perintah artisan (php artisan ...)
        if ($this->app->runningInConsole()) {
            return;
        }

        // 2) Jika tabel belum ada, jangan query
        try {
            if (
                !Schema::hasTable('withdrawal_users') ||
                !Schema::hasTable('users')
            ) {
                return;
            }

            if (function_exists('getPendingWithdrawals') && function_exists('getPendingWithdrawalsCount')) {
                View::share('pendingWithdrawals', getPendingWithdrawals());
                View::share('pendingWithdrawalsCount', getPendingWithdrawalsCount());
            }
        } catch (\Throwable $e) {
            // 3) Fail-safe: kalau ada error DB apapun, jangan blok aplikasi/CLI
            return;
        }
    }
}
