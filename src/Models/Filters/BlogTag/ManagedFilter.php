<?php

namespace Innoboxrr\LaravelBlog\Models\Filters\BlogTag;

use Innoboxrr\SearchSurge\Search\Utils\Managed;

class ManagedFilter extends Managed
{

    public static function canView($query, $user, array $args = [])
    {   
        if(method_exists($user, 'managedBlogTagFilter')) {
            $query = $user->managedBlogTagFilter($query, $args);
        }
        return $query;
    }
}