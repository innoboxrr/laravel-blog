<?php

namespace Innoboxrr\LaravelBlog\Exports;

use Innoboxrr\LaravelBlog\Models\BlogSubscriber;
use Innoboxrr\SearchSurge\Search\Builder;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class BlogSubscribersExports implements FromView
{

    protected $data;

    public function __construct( array $data) 
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view(
            config(
                'laravel-blog.excel_view', 
                'laravel-blog::excel.'
            ) . 'blog_subscriber', 
            [
                'blog_subscribers' => $this->getQuery(),
                'exportCols' => BlogSubscriber::$export_cols
            ]
        );
    }

    public function getQuery()
    {   
        $builder = new Builder();
        return $builder->get(BlogSubscriber::class, $this->data);
    }

}