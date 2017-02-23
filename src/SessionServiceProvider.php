<?php

namespace WebModularity\LaravelSession;

use Illuminate\Support\ServiceProvider;

class SessionServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->app->make('session')->extend('wm-database', function ($app) {
            // Return implementation of SessionHandlerInterface...
            $sessionConnection = $app->make('db')->connection(config('session.connection'));
            return new DatabaseSessionHandler(
                $sessionConnection,
                config('session.table'),
                config('session.lifetime'),
                $app
            );
        });
    }
}
