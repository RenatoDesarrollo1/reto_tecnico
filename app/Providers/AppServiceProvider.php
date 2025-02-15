<?php

namespace App\Providers;

use App\Services\Contracts\AuthServiceInterface;
use App\Services\AuthService;
use App\Services\Contracts\ProductServiceInterface;
use App\Services\ProductService;
use App\Services\Contracts\SaleServiceInterface;
use App\Services\SaleService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(ProductServiceInterface::class, ProductService::class);
        $this->app->bind(SaleServiceInterface::class, SaleService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
