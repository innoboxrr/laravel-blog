<?php

namespace Innoboxrr\LaravelBlog\Http\Middleware;

use Closure;
use App\Models\Blog;

class ResolveBlog
{
    public function handle($request, Closure $next)
    {
        $host = $request->getHost();
        $slug = $request->route('slug');

        // Resolver el blog basado en el dominio o el slug
        $blog = Blog::resolveBlog($host, $slug);

        // Compartir el blog con todas las vistas
        view()->share('currentBlog', $blog);
        view()->share('theme', $blog->theme ?? 'default');

        return $next($request);
    }
}
