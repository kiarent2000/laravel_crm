<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class PriceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PriceCalculateService::class, function() {};)
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
