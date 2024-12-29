<?php

namespace Innoboxrr\LaravelBlog\Exports;

use Innoboxrr\LaravelBlog\Models\BlogCategory;
use Innoboxrr\SearchSurge\Search\Builder;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class BlogCategoriesExports implements FromView
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
                'innoboxrrlaravelblog.excel_view', 
                'innoboxrrlaravelblog::excel.'
            ) . 'blog_category', 
            [
                'blog_categories' => $this->getQuery(),
                'exportCols' => BlogCategory::$export_cols
            ]
        );
    }

    public function getQuery()
    {   
        $builder = new Builder();
        return $builder->get(BlogCategory::class, $this->data);
    }

}