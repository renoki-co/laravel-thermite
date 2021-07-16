<?php

namespace RenokiCo\LaravelThermite;

use Illuminate\Support\ServiceProvider;

class LaravelThermiteServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('config.php'),
        ], 'config');

        $this->mergeConfigFrom(
            __DIR__.'/../config/config.php', 'config'
        );
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
