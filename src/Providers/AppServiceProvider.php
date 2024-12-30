<?php

namespace Innoboxrr\LaravelBlog\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register()
    {
        
        $this->mergeConfigFrom(__DIR__ . '/../../config/laravel-blog.php', 'laravel-blog');

    }

    public function boot()
    {
        
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'laravel-blog');

        if ($this->app->runningInConsole()) {
            
            $this->publishes([__DIR__.'/../../resources/views' => resource_path('views/vendor/laravel-blog'),], 'views');

            $this->publishes([__DIR__.'/../../config/laravel-blog.php' => config_path('laravel-blog.php')], 'config');

        }

    }
    
}