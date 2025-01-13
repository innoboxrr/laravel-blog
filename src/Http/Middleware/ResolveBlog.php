<?php

namespace Innoboxrr\LaravelBlog\Http\Middleware;

use Closure;
use Innoboxrr\LaravelBlog\Models\Blog;

class ResolveBlog
{
    public function handle($request, Closure $next)
    {
        $host = $request->getHost();
        $slug = $request->route('slug');

        // Si no es un subdominio de blog, continuar
        if(!str_starts_with($host, 'blog.')) return $next($request);

        // Si el host viene como subdominio, recuperar el dominio principal
        $domainParts = explode('.', $host);
        if (count($domainParts) > 2) {
            // Asumimos que el subdominio es el primer elemento
            $subdomain = array_shift($domainParts);
            $host = implode('.', $domainParts);
        } else {
            $subdomain = null;
        }

        // Resolver el blog basado en el subdominio, dominio o el slug
        $blog = Blog::resolveBlog($host, $slug);

        // Compartir el blog con todas las vistas
        view()->share('currentBlog', $blog);
        view()->share('theme', $blog->theme ?? 'default');

        return $next($request);
    }
}
