<?php


namespace App\Providers;

use App\Services\BasketService;
use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(BasketService::class, function ($app) {
            return new BasketService();
        });
    }
}
