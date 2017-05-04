<?php

namespace adamilleriam\authorization;

use Illuminate\Support\ServiceProvider;

class authorizationServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // Load routes
        $this->loadRoutesFrom(__DIR__ . '/Routes/routes.php');
        // Load Migrations
        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');
        // Publishes

        $this->publishes([
            __DIR__.'/Resources/Views/authorization'=>base_path('resources/views')
        ]);
        $this->publishes([
            __DIR__.'/Config'=>base_path('config')
        ]);
        $this->publishes([
            __DIR__.'/app/Http/Controllers'=>base_path('app/Http/Controllers')
        ]);
        $this->publishes([
            __DIR__.'/app/Http/Middleware'=>base_path('app/Http/Middleware')
        ]);
        $this->publishes([
            __DIR__.'/app/Http/Helper'=>base_path('app/Http')
        ]);
        $this->publishes([
            __DIR__.'/app/Models'=>base_path('app')
        ]);
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}