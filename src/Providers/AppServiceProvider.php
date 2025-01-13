<?php

namespace Innoboxrr\LaravelBlog\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ReflectionClass;

class AppServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/laravel-blog.php', 'laravel-blog');
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->registerLivewireComponents();
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'laravel-blog');
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__.'/../../resources/views' => resource_path('views/vendor/laravel-blog'),], 'views');
            $this->publishes([__DIR__.'/../../config/laravel-blog.php' => config_path('laravel-blog.php')], 'config');
        }
    }

    protected function registerLivewireComponents()
    {
        $livewirePath = __DIR__.'/../Http/Livewire';
        $namespace = 'Innoboxrr\\LaravelBlog\\Http\\Livewire';
        $viewsPath = __DIR__.'/../../resources/views/livewire';

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($livewirePath)
        );

        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $class = $namespace . '\\' . str_replace(
                    ['/', '.php'],
                    ['\\', ''],
                    substr($file->getPathname(), strlen($livewirePath) + 1)
                );

                if (class_exists($class) && is_subclass_of($class, \Livewire\Component::class)) {
                    $reflection = new ReflectionClass($class);
                    $relativePath = str_replace(
                        '\\',
                        '/',
                        substr($reflection->getName(), strlen($namespace) + 1)
                    );

                    $viewName = 'laravel-blog::livewire.' . str_replace(
                        '/',
                        '-',
                        strtolower($relativePath)
                    );

                    Livewire::component($viewName, $class);
                }
            }
        }
    }
}