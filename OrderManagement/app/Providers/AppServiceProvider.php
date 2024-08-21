<?php

namespace App\Providers;

use App\Services\CampaignService;
use App\Services\OrderService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(OrderService::class, function ($app) {
            return new OrderService($app->make(CampaignService::class));
        });

        $this->app->singleton(CampaignService::class, function ($app) {
            return new CampaignService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }
}
