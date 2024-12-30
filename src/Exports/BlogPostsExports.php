<?php

namespace Innoboxrr\LaravelBlog\Exports;

use Innoboxrr\LaravelBlog\Models\BlogPost;
use Innoboxrr\SearchSurge\Search\Builder;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class BlogPostsExports implements FromView
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
            ) . 'blog_post', 
            [
                'blog_posts' => $this->getQuery(),
                'exportCols' => BlogPost::$export_cols
            ]
        );
    }

    public function getQuery()
    {   
        $builder = new Builder();
        return $builder->get(BlogPost::class, $this->data);
    }

}