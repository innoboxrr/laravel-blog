<?php

namespace Innoboxrr\LaravelBlog\Models\Filters\BlogPost;

use Illuminate\Database\Eloquent\Builder;
use Innoboxrr\SearchSurge\Search\Utils\Order;
use Innoboxrr\SearchSurge\Search\Support\DataContainer;

class CategoryFilter
{

    public static function apply(Builder $query, DataContainer $data)
    {

        if ($data->category_id) {
            $query->whereHas('categories', function ($q) use ($data) {
                $q->where('blog_categories.id', $data->category_id);
            });
        }

        return $query;

    }

}
