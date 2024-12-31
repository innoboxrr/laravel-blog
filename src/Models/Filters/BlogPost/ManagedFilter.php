<?php

namespace Innoboxrr\LaravelBlog\Models\Filters\BlogPost;

use Innoboxrr\SearchSurge\Search\Utils\Managed;

class ManagedFilter extends Managed
{

    public static function canView($query, $user, array $args = [])
    {   
        if(method_exists($user, 'managedBlogPostFilter')) {
            $query = $user->managedBlogPostFilter($query, $args);
        }
        return $query;
    }
}