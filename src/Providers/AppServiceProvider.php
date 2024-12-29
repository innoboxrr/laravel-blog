<?php

namespace Innoboxrr\LaravelBlog\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register()
    {
        
        // $this->mergeConfigFrom(__DIR__ . '/../../config/innoboxrrlaravelblog.php', 'innoboxrrlaravelblog');

    }

    public function boot()
    {
        
        // $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        // $this->loadViewsFrom(__DIR__.'/../../resources/views', 'innoboxrrlaravelblog');

        if ($this->app->runningInConsole()) {
            
            // $this->publishes([__DIR__.'/../../resources/views' => resource_path('views/vendor/innoboxrrlaravelblog'),], 'views');

            // $this->publishes([__DIR__.'/../../config/innoboxrrlaravelblog.php' => config_path('innoboxrrlaravelblog.php')], 'config');

        }

    }
    
}