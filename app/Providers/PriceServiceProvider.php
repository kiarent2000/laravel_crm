<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\PriceCalculateService;


class PriceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PriceCalculateService::class, function($app) {
            return new PriceCalculateService();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
