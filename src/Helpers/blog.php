<?php

use Innoboxrr\LaravelBlog\Helpers\BlogHelper;

if (!function_exists('blog_route')) {
    function blog_route($name, $parameters = [], $absolute = false)
    {
        return BlogHelper::route($name, $parameters, $absolute);
    }
}

if (!function_exists('blog_post_route')) {
    function blog_post_route($post)
    {
        return blog_route(
            'post', 
            [
                'blog' => $post->blog_id, 
                'post' => $post->slug
            ]);
    }
}

if (!function_exists('blog_category_route')) {
    function blog_category_route($category)
    {
        return blog_route(
            'category', 
            [
                'blog' => $category->blog_id, 
                'category' => $category->slug
            ]);
    }
}

if (!function_exists('blog_login_route')) {
    function blog_login_route($post)
    {
        return blog_route('login');
    }
}

if(!function_exists('blog_assets')) {
    function blog_assets($theme, $folder, $path)
    {
        return blog_route(
            'assets', 
            [
                'theme' => $theme, 
                'folder' => $folder, 
                'path' => $path
        ]);
    }
}

if(!function_exists('getFormattedPhone')) {
    function getFormattedPhone($phone)
    {
        try {
            $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
            $numberProto = $phoneUtil->parse($phone, 'ZZ');

            if (!$phoneUtil->isValidNumber($numberProto)) {
                throw new \Exception("Número inválido");
            }

            $dialCode = $numberProto->getCountryCode();
            $nationalNumber = $numberProto->getNationalNumber();

            return [
                'formatted' => "{$dialCode} {$nationalNumber}",
                'dial_code' => $dialCode,
                'national_number' => $nationalNumber,
                'country_iso' => $phoneUtil->getRegionCodeForNumber($numberProto),
            ];
        } catch (\Exception $e) {
            return null;
        }
    }
}