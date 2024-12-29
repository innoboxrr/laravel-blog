<?php

namespace Innoboxrr\LaravelBlog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Innoboxrr\Traits\MetaOperations;
use Innoboxrr\Traits\ModelAppendsTrait;
use Innoboxrr\LaravelBlog\Models\Traits\Relations\BlogCategoryRelations;
use Innoboxrr\LaravelBlog\Models\Traits\Storage\BlogCategoryStorage;
use Innoboxrr\LaravelBlog\Models\Traits\Assignments\BlogCategoryAssignment;
use Innoboxrr\LaravelBlog\Models\Traits\Operations\BlogCategoryOperations;
use Innoboxrr\LaravelBlog\Models\Traits\Mutators\BlogCategoryMutators;

class BlogCategory extends Model
{

    use HasFactory,
        SoftDeletes,
        MetaOperations,
        ModelAppendsTrait,
        BlogCategoryRelations,
        BlogCategoryStorage,
        BlogCategoryAssignment,
        BlogCategoryOperations,
        BlogCategoryMutators;
        
    protected $fillable = [
        'name',
        'slug',
        'order',
        'description',
        'parent_id',
        'blog_id',
    ];

    protected $creatable = [
        'name',
        'slug',
        'order',
        'description',
        'parent_id',
        'blog_id',
    ];

    protected $updatable = [
        'name',
        'slug',
        'order',
        'description',
        'parent_id',
    ];

    protected $casts = [];

    protected $protected_metas = [];

    protected $editable_metas = [];

    public static $export_cols = [
        'name',
        'slug',
        'order',
        'description',
        'parent_id',
        'blog_id',
    ];

    public static $loadable_relations = [
        'blog',
        'parent',
        'children',
        'posts',
    ];

    public static $loadable_counts = [
        'blog',
        'parent',
        'children',
        'posts',
    ];

    protected static function newFactory()
    {
        return \Innoboxrr\LaravelBlog\Database\Factories\BlogCategoryFactory::new();
    }
}