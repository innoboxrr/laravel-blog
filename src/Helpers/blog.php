<?php

use Innoboxrr\LaravelBlog\Helpers\BlogHelper;

if (!function_exists('blog_route')) {
    function blog_route($name, $parameters = [], $absolute = true)
    {
        return BlogHelper::route($name, $parameters, $absolute);
    }
}