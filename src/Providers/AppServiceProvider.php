<?php

namespace Innoboxrr\LaravelBlog\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ReflectionClass;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

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

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($livewirePath)
        );

        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                // Generar la clase a partir de la ruta
                $class = $namespace . '\\' . str_replace(
                    ['/', '\\', '.php'],
                    ['\\', '\\', ''],
                    substr($file->getPathname(), strlen($livewirePath) + 1)
                );

                if (class_exists($class) && is_subclass_of($class, \Livewire\Component::class)) {
                    // Convertir la ruta relativa de la clase a kebab-case
                    $relativePath = str_replace(
                        '\\',
                        '/',
                        substr($class, strlen($namespace) + 1)
                    );

                    // Convertir cada segmento del path a kebab-case
                    $kebabPath = collect(explode('/', $relativePath))
                        ->map(fn($segment) => Str::kebab($segment))
                        ->implode('.');

                    $viewName = 'laravel-blog::livewire.' . $kebabPath;

                    // Log para depurar el registro
                    // Log::info("Registrando componente: $viewName => $class");

                    // Registrar el componente en Livewire
                    Livewire::component($viewName, $class);
                }
            }
        }
    }
}