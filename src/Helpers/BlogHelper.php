<?php

namespace Innoboxrr\LaravelBlog\Helpers;

use Innoboxrr\LaravelBlog\Models\Blog;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class BlogHelper
{
    public static function isBlog($request): bool
    {
        if ($blog = self::getBlogFromRequest()) {
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

    public static function getBlogFromRequest(): ?Blog
    {
        if (self::contextIsApp()) {
            return self::getBlogFromPath();
        } elseif (self::contextIsBlog()) {
            return self::getBlogFromDomain();
        }

        return null;
    }

    public static function contextIsApp(): bool
    {
        $host = request()->getHost();
        $path = request()->getPathInfo();
        $referer = request()->headers->get('referer', '');

        if ($path === '/livewire/update' && $referer) {
            $refererPath = parse_url($referer, PHP_URL_PATH) ?: '';
            if ($refererPath !== '') {
                $path = $refererPath;
            }
        }

        if (!Str::startsWith($path, '/blog')) {
            return false;
        }

        return $host === config('app.app_host', 'seguropro.test.com');
    }

    public static function contextIsBlog(): bool
    {
        $host = request()->getHost();
        return Str::startsWith($host, 'blog.');
    }

    public static function getBlogDomain(): ?string
    {
        $host = request()->getHost();

        if (!Str::startsWith($host, 'blog.')) {
            return null;
        }

        $parts = explode('.', $host);
        if (count($parts) <= 1 || $parts[0] !== 'blog') {
            return null;
        }

        $domain = implode('.', array_slice($parts, 1));
        return $domain !== '' ? $domain : null;
    }

    public static function getBlogFromDomain(): ?Blog
    {
        $domain = self::getBlogDomain();
        if (!$domain) {
            return null;
        }

        $blog = Blog::resolveBlog($domain);
        if (!$blog) {
            return null;
        }

        // Config dinámico de dominio / URL / sesión
        Config::set('session.domain', '.' . $blog->url['host']);
        Config::set('app.url', $blog->url['scheme'] . '://' . $blog->url['host']);
        Config::set('app.name', $blog->name);

        $sessionName = str_replace('.', '_', $blog->url['host']) . '_session';
        Session::setName($sessionName);
        Config::set('session.cookie', $sessionName);

        $stateful = config('sanctum.stateful');
        if (!is_array($stateful)) {
            $stateful = [];
        }
        if (!in_array($blog->url['host'], $stateful, true)) {
            $stateful[] = $blog->url['host'];
        }
        Config::set('sanctum.stateful', $stateful);

        return $blog;
    }

    public static function getBlogFromPath(): ?Blog
    {
        $path = request()->getPathInfo();
        $referer = request()->headers->get('referer', '');

        if ($path === '/livewire/update' && $referer) {
            $refererPath = parse_url($referer, PHP_URL_PATH) ?: '';
            if ($refererPath !== '') {
                $path = $refererPath;
            }
        }

        // /blog/{blog}/{...}
        $slug = explode('/', trim($path, '/'))[1] ?? null;
        if (!$slug) {
            return null;
        }

        // Si tu Blog::find espera ID numérico y tú usas slug, cambia por where('slug', $slug)->first()
        return Blog::find($slug) ?: Blog::where('id', $slug)->orWhere('slug', $slug)->first();
    }

    public static function route(string $name, array $parameters = [], bool $absolute = false): string
    {
        // Limpia nulls y castea a string todo parámetro escalar
        $clean = [];
        foreach ($parameters as $k => $v) {
            if (is_null($v)) {
                $clean[$k] = '';
            } elseif (is_scalar($v)) {
                $clean[$k] = (string) $v;
            } else {
                // Evita pasar arrays/objetos a la generación de rutas
                $clean[$k] = (string) $v;
            }
        }

        if (self::contextIsBlog()) {
            unset($clean['blog']);

            $domain = self::getBlogDomain() ?? '';
            $url = route('blog.' . $name, array_merge($clean, ['domain' => $domain]), $absolute);
        } else {
            $url = route('blog.app.' . $name, $clean, $absolute);
        }

        // Fuerza https si te interesa (evita mezclar contenido)
        if (Str::startsWith($url, 'http://')) {
            $url = preg_replace('#^http://#', 'https://', $url) ?: $url;
        }

        return $url;
    }
}
