<?php

namespace Innoboxrr\LaravelBlog\Models\Filters\BlogCategory;

use Innoboxrr\SearchSurge\Search\Utils\Managed;

class ManagedFilter extends Managed
{

    public static function canView($query, $user, array $args = [])
    {   
        if(method_exists($user, 'managedBlogCategoryFilter')) {
            $query = $user->managedBlogCategoryFilter($query, $args);
        }
        return $query;
    }
}