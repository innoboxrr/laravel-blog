<?php

namespace Innoboxrr\LaravelBlog\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Innoboxrr\LaravelBlog\Models\Blog;
use Innoboxrr\LaravelBlog\Helpers\BlogHelper;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        parent::boot();

        $this->routes(function () {
            $this->mapAppRoutes();
            $this->mapBlogRoutes();
            $this->mapApiRoutes();   
        });
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

    protected function mapAppRoutes()
    {
        Route::middleware('web')
            ->as('blog.')
            ->group(__DIR__ . '/../../routes/app.php');
    }

    protected function mapBlogRoutes()
    {
        Route::middleware('web')
            ->as('blog.')
            ->group(__DIR__ . '/../../routes/blog.php');
    }
}
