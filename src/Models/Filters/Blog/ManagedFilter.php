<?php

namespace Innoboxrr\LaravelBlog\Models\Filters\Blog;

use Innoboxrr\SearchSurge\Search\Utils\Managed;

class ManagedFilter extends Managed
{

    public static function canView($query, $user, array $args = [])
    {   
        if(method_exists($user, 'managedBlogFilter')) {
            $query = $user->managedBlogFilter($query, $args);
        }
        return $query;
    }
}