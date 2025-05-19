<?php

namespace Innoboxrr\LaravelBlog\Helpers;

use Innoboxrr\LaravelBlog\Models\Blog;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

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
        $referer = request()->headers->get('referer');

        if($path == '/livewire/update') {
            $refererPath = parse_url($referer, PHP_URL_PATH);
            $path = $refererPath;
        }

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
        $blog = Blog::resolveBlog(self::getBlogDomain());

        Config::set('session.domain', '.' . $blog->url['host']);
        Config::set('app.url', $blog->url['scheme'] . '://' . $blog->url['host']);
        Config::set('app.name', $blog->name);

        $sessionName = str_replace('.', '_', $blog->url['host']) . '_session';
        Session::setName($sessionName);
        Config::set('session.cookie', $sessionName);

        $stateful_array = config('sanctum.stateful');
        array_push($stateful_array, $blog->url['host']);
        Config::set('sanctum.stateful', $stateful_array);

        // Forzar https
        \URL::forceScheme('https');

        return $blog;
    }

    public static function getBlogFromPath()
    {
        $path = request()->getPathInfo();

        $referer = request()->headers->get('referer');
        if($path == '/livewire/update') {
            $refererPath = parse_url($referer, PHP_URL_PATH);
            $path = $refererPath;
        }

        $slug = explode('/', $path)[2] ?? null;
        return Blog::find($slug);
    }   

    public static function route($name, $parameters = [], $absolute = true)
    {
        \URL::forceScheme('https');
        
        if(self::contextIsApp()){
            return route(
                'blog.app.' . $name, 
                $parameters, 
                $absolute
            );
        } elseif(self::contextIsBlog()){

            // unser blog parameter
            unset($parameters['blog']);

            return route(
                'blog.' . $name, 
                array_merge($parameters, ['domain' => self::getBlogDomain()]), 
                $absolute
            );
        }
    }
}

