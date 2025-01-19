<?php

namespace Innoboxrr\LaravelBlog\Models\Filters\BlogCategory;

use Illuminate\Database\Eloquent\Builder;
use Innoboxrr\SearchSurge\Search\Utils\Order;
use Innoboxrr\SearchSurge\Search\Support\DataContainer;

class InheritanceFilter
{

    public static function apply(Builder $query, DataContainer $data)
    {
        if($data->only_parents == 1 || $data->only_parents == true) {
            $query->whereNull('parent_id');
        }

        if($data->parent_id) {
            $query->where('parent_id', $data->parent_id);
        }

        
        return $query;
    }

}
