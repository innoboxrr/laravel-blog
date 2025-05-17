<?php

namespace Innoboxrr\LaravelBlog\Models\Filters\BlogCategory;

use Illuminate\Database\Eloquent\Builder;
use Innoboxrr\SearchSurge\Search\Utils\Order;
use Innoboxrr\SearchSurge\Search\Support\DataContainer;

class BlogFilter
{

    public static function apply(Builder $query, DataContainer $data)
    {

        if ($data->blog_id) {

            $query->where('blog_id', $data->blog_id);

        }

        $query = Order::orderBy($query, $data, 'blog_id');

        return $query;

    }

}
