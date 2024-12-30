<?php

namespace Innoboxrr\LaravelBlog\Exports;

use Innoboxrr\LaravelBlog\Models\BlogTag;
use Innoboxrr\SearchSurge\Search\Builder;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class BlogTagsExports implements FromView
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
            ) . 'blog_tag', 
            [
                'blog_tags' => $this->getQuery(),
                'exportCols' => BlogTag::$export_cols
            ]
        );
    }

    public function getQuery()
    {   
        $builder = new Builder();
        return $builder->get(BlogTag::class, $this->data);
    }

}