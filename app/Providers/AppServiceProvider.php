<?php

namespace App\Providers;

use App\Models\Penerimaan;
use App\Models\Pengeluaran;
use App\Observers\PenerimaanObserver;
use Illuminate\Support\Facades\Route;
use App\Observers\PengeluaranObserver;
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
    public function boot(): void
    {
        //
    }
}
