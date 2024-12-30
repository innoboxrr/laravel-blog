<?php

namespace Innoboxrr\LaravelBlog\Exports;

use Innoboxrr\LaravelBlog\Models\Blog;
use Innoboxrr\SearchSurge\Search\Builder;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class BlogsExports implements FromView
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
            ) . 'blog', 
            [
                'blogs' => $this->getQuery(),
                'exportCols' => Blog::$export_cols
            ]
        );
    }

    public function getQuery()
    {   
        $builder = new Builder();
        return $builder->get(Blog::class, $this->data);
    }

}