<?php

use Innoboxrr\LaravelBlog\Helpers\BlogHelper;

if (!function_exists('blog_route')) {
    function blog_route(string $name, array $parameters = [], bool $absolute = false): string
    {
        // Asegura SIEMPRE string
        return (string) BlogHelper::route($name, $parameters, $absolute);
    }
}

if (!function_exists('blog_post_route')) {
    function blog_post_route($post): string
    {
        // Fallback si no hay slug
        $postIdOrSlug = !empty($post->slug) ? $post->slug : (string) $post->id;

        return blog_route('post', [
            'blog' => (string) $post->blog_id,
            'post' => $postIdOrSlug,
        ]);
    }
}

if (!function_exists('blog_category_route')) {
    function blog_category_route($category): string
    {
        $categoryIdOrSlug = !empty($category->slug) ? $category->slug : (string) $category->id;

        return blog_route('category', [
            'blog' => (string) $category->blog_id,
            'category' => $categoryIdOrSlug,
        ]);
    }
}

if (!function_exists('blog_login_route')) {
    function blog_login_route(): string
    {
        // No aceptes params que no usas; siempre string
        return blog_route('login');
    }
}

if (!function_exists('blog_assets')) {
    function blog_assets(string $theme, string $folder, string $path): string
    {
        // Evita doble slash y encodea el path por seguridad
        $cleanPath = ltrim($path, '/');
        return blog_route('assets', [
            'theme'  => $theme,
            'folder' => $folder,
            'path'   => $cleanPath,
        ]);
    }
}

if (!function_exists('getFormattedPhone')) {
    function getFormattedPhone($phone): ?array
    {
        try {
            $phoneUtil   = \libphonenumber\PhoneNumberUtil::getInstance();
            $numberProto = $phoneUtil->parse((string) $phone, 'ZZ');

            if (!$phoneUtil->isValidNumber($numberProto)) {
                throw new \Exception('Número inválido');
            }

            $dialCode       = (string) $numberProto->getCountryCode();
            $nationalNumber = (string) $numberProto->getNationalNumber();

            return [
                'formatted'       => "{$dialCode} {$nationalNumber}",
                'dial_code'       => $dialCode,
                'national_number' => $nationalNumber,
                'country_iso'     => $phoneUtil->getRegionCodeForNumber($numberProto),
            ];
        } catch (\Exception $e) {
            return null;
        }
    }
}
