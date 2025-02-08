<?php

namespace Innoboxrr\LaravelBlog\Helpers;

use Innoboxrr\LaravelBlog\Models\Blog;
use Illuminate\Http\Request;

class BlogHelper
{
    public static function isBlog($request)
    {
        if ($blog = BlogHelper::getBlogFromRequest()) {
            // Compartir el blog con todas las vistas
            view()->share('currentBlog', $blog);
            view()->share('theme', $blog->theme ?? 'default');
            $request->merge([
                'is_blog' => true,
                'blog_id' => $blog->id,
            ]);

            return true;
        }
        return false;
    }

    public static function getBlogFromRequest()
    {
        if(self::contextIsApp()){
            return self::getBlogFromPath();
        } elseif(self::contextIsBlog()){
            return self::getBlogFromDomain();
        }
        return null;
    }

    public static function contextIsApp()
    {
        $host = request()->getHost();
        $path = request()->getPathInfo();

        // Si path inicia como /blog o /blog/ entonces es un blog
        if(!str_starts_with($path, '/blog')){
            return false;
        }
        return $host === config('app.app_host', 'seguropro.test.com');
    }

    public static function contextIsBlog()
    {
        $host = request()->getHost();
        return str_starts_with($host, 'blog.');
    }

    public static function getBlogDomain()
    {
        $host = request()->getHost();
        if(!str_starts_with($host, 'blog.')){
            return null;
        }

        // Extrae el dominio sin el subdominio "blog."
        if(explode('.', $host)[0] == 'blog'){
            $domain = implode('.', array_slice(explode('.', $host), 1));
        }

        return $domain;
    }

    public static function getBlogFromDomain()
    {
        return Blog::resolveBlog(self::getBlogDomain());
    }

    public static function getBlogFromPath()
    {
        $path = request()->getPathInfo();
        $slug = explode('/', $path)[2] ?? null;
        return Blog::find($slug);
    }   

    public static function route($name, $parameters = [], $absolute = true)
    {
        if(self::contextIsApp()){
            return route('blog.app.' . $name, $parameters['app'], $absolute);
        } elseif(self::contextIsBlog()){
            return route('blog.' . $name, array_merge($parameters['blog'], ['domain' => self::getBlogDomain()]), $absolute);
        }
    }
}

