<?php

namespace Innoboxrr\LaravelBlog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Innoboxrr\Traits\MetaOperations;
use Innoboxrr\Traits\ModelAppendsTrait;
use Innoboxrr\LaravelBlog\Models\Traits\Relations\BlogTagRelations;
use Innoboxrr\LaravelBlog\Models\Traits\Storage\BlogTagStorage;
use Innoboxrr\LaravelBlog\Models\Traits\Assignments\BlogTagAssignment;
use Innoboxrr\LaravelBlog\Models\Traits\Operations\BlogTagOperations;
use Innoboxrr\LaravelBlog\Models\Traits\Mutators\BlogTagMutators;

class BlogTag extends Model
{

    use HasFactory,
        SoftDeletes,
        MetaOperations,
        ModelAppendsTrait,
        BlogTagRelations,
        BlogTagStorage,
        BlogTagAssignment,
        BlogTagOperations,
        BlogTagMutators;
        
    protected $fillable = [
        'name',
        'usage',
        'blog_id',
    ];

    protected $creatable = [
        'name',
        'blog_id',
    ];

    protected $updatable = [
        'name',
    ];

    protected $casts = [];

    protected $protected_metas = [];

    protected $editable_metas = [];

    public static $export_cols = [
        'id',
        'name',
        'usage',
        'blog_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public static $loadable_relations = [
        'blog',
        'posts',
    ];

    public static $loadable_counts = [
        'blog',
        'posts',
    ];

    /*
    protected static function newFactory()
    {
        return \Innoboxrr\LaravelBlog\Database\Factories\BlogTagFactory::new();
    }
    */

}
