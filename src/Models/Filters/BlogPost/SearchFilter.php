<?php

namespace Innoboxrr\LaravelBlog\Models\Filters\BlogPost;

use Illuminate\Database\Eloquent\Builder;
use Innoboxrr\SearchSurge\Search\Utils\Order;
use Innoboxrr\SearchSurge\Search\Support\DataContainer;

class SearchFilter
{
    public static function apply(Builder $query, DataContainer $data)
    {
        if ($data->search) {
            $query->where(function ($q) use ($data) {
                $q->where('title', 'like', '%' . $data->search . '%')
                  ->orWhere('content', 'like', '%' . $data->search . '%');
            });
        }
        return $query;
    }
}