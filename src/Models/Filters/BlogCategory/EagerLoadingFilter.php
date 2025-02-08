<?php

namespace Innoboxrr\LaravelBlog\Models\Filters\BlogCategory;

use Illuminate\Database\Eloquent\Builder;
use Innoboxrr\SearchSurge\Search\Utils\Order;
use Innoboxrr\SearchSurge\Search\Support\DataContainer;

class EagerLoadingFilter
{

    public static function apply(Builder $query, DataContainer $data)
    {

        if ($data->load_children == 1 || $data->load_children == true) {
            $query->with(['children']);
        }

        if($data->load_posts_count == 1 || $data->load_posts_count == true) {
            $query->withCount(['posts']);
        }

        /*
        if ($data->load_relation == 1 || $data->load_relation == true) {
            $query->with(['relation']);
        }
        */
        return $query;
    }

}
