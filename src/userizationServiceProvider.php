<?php

namespace adamilleriam\authorization;

use Illuminate\Support\ServiceProvider;

class userizationServiceProvider extends ServiceProvider
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
        // Publishes

        $this->publishes([
            __DIR__.'/Database/migrations//userization'=>base_path('database/migrations/userization')
        ]);
        $this->publishes([
            __DIR__.'/Database/seeds/userization'=>base_path('database/seeds/userization')
        ]);
        $this->publishes([
            __DIR__ . '/Resources/Views/userization' =>base_path('resources/views/userization')
        ]);
        $this->publishes([
            __DIR__.'/Config'=>base_path('config')
        ]);
        $this->publishes([
            __DIR__.'/app/Http/Controllers/Userization'=>base_path('app/Http/Controllers/Userization')
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