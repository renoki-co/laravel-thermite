<?php

namespace RenokiCo\LaravelThermite;

use Illuminate\Database\Connection;
use Illuminate\Support\ServiceProvider;
use RenokiCo\LaravelThermite\Database\Connection as CockroachConnection;
use RenokiCo\LaravelThermite\Database\Connector;

class LaravelThermiteServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        Connection::resolverFor('cockroachdb', function ($connection, $database, $prefix, $config) {
            $connection = (new Connector)->connect($config);

            return new CockroachConnection(
                $connection, $database, $prefix, $config
            );
        });
    }
}
