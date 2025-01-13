<?php

namespace Innoboxrr\LaravelBlog\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{

    public function map()
    {
        $this->mapApiRoutes();     
        $this->mapWebRoutes(); 
    }

    protected function mapApiRoutes()
    {
        foreach (glob(__DIR__ . '/../../routes/api/models/*.php') as $file) {
            $name = basename($file, '.php');
            Route::middleware('api')
                ->prefix('api/larablog/' . $name)
                ->as('api.larablog.' . $name . '.')
                ->namespace('Innoboxrr\LaravelBlog\Http\Controllers')
                ->group($file);
        }
    }

    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->as('larablog.')
            ->group(__DIR__ . '/../../routes/web.php');
    }

}
