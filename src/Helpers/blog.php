<?php

use Innoboxrr\LaravelBlog\Helpers\BlogHelper;

if (!function_exists('blog_route')) {
    function blog_route($name, $parameters = [], $absolute = true)
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
                'app' => [
                    'blog' => $post->blog_id, 
                    'postSlug' => $post->slug
                ], 
                'blog' => [
                    'postSlug' => $post->slug
                    ]
                ]
            );
    }
}

if(!function_exists('blog_assets')) {
    function blog_assets($theme, $folder, $path)
    {
        return blog_route(
            'assets', 
            [
                'app' => [
                    'theme' => $theme, 
                    'folder' => $folder, 
                    'path' => $path
                ], 
                'blog' => [
                    'theme' => $theme, 
                    'folder' => $folder, 
                    'path' => $path
                    ]
                ]
            );
    }
}