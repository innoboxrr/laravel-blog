<?php

namespace Innoboxrr\LaravelBlog\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Innoboxrr\LaravelBlog\Models\Blog;

class RouteServiceProvider extends ServiceProvider
{
    public function map()
    {
        // Siempre registra las rutas API para el dominio principal
        $this->mapApiRoutes();

        // Verifica el dominio actual y registra las rutas web correspondientes
        $host = request()->getHost();

        if ($this->isAppDomain($host)) {
            $this->mapWebRoutes();
        } elseif ($this->isBlogDomain($host)) {
            // Subdominios personalizados
            $this->mapBlogRoutes($host);
        } 
    }

    /**
     * Siempre registra las rutas API.
     */
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

    /**
     * Registra las rutas WEB para el dominio principal.
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->group(base_path('routes/web.php'));
    }

    /**
     * Registra las rutas para subdominios personalizados.
     */
    protected function mapBlogRoutes($host)
    {
        if(!str_starts_with($host, 'blog.')){
            abort(404, 'Blog not found');
        }

        // Extrae el dominio sin el subdominio "blog."
        if(explode('.', $host)[0] == 'blog'){
            $domain = implode('.', array_slice(explode('.', $host), 1));
        }

        // Busca el blog en la base de datos
        $blog = Blog::where('domain', $domain)->first();

        if (!$blog) {
            abort(404, 'Blog not found');
        }

        // Registra las rutas específicas para el blog
        Route::domain($host)
            ->middleware('web')
            ->group(__DIR__ . '/../../routes/blog.php');
    }

    /**
     * Verifica si es el dominio principal de la aplicación.
     */
    protected function isAppDomain($host)
    {
        return $host === config('app.app_host', 'seguropro.test.com');
    }

    /**
     * Verifica si el dominio es un subdominio personalizado.
     */
    protected function isBlogDomain($host)
    {
        return str_starts_with($host, 'blog.');
    }
}
