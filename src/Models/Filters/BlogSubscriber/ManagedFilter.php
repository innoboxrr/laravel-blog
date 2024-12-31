<?php

namespace Innoboxrr\LaravelBlog\Models\Filters\BlogSubscriber;

use Innoboxrr\SearchSurge\Search\Utils\Managed;

class ManagedFilter extends Managed
{

    public static function canView($query, $user, array $args = [])
    {   
        if(method_exists($user, 'managedBlogSubscriberFilter')) {
            $query = $user->managedBlogSubscriberFilter($query, $args);
        }
        return $query;
    }
}