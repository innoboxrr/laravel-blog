<?php

namespace Innoboxrr\LaravelBlog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Innoboxrr\Traits\MetaOperations;
use Innoboxrr\Traits\ModelAppendsTrait;
use Innoboxrr\LaravelAudit\Support\Traits\Auditable;
use Innoboxrr\LaravelBlog\Models\Traits\Relations\BlogPostRelations;
use Innoboxrr\LaravelBlog\Models\Traits\Storage\BlogPostStorage;
use Innoboxrr\LaravelBlog\Models\Traits\Assignments\BlogPostAssignment;
use Innoboxrr\LaravelBlog\Models\Traits\Operations\BlogPostOperations;
use Innoboxrr\LaravelBlog\Models\Traits\Mutators\BlogPostMutators;
use Innoboxrr\LaravelBlog\Models\Traits\Scopes\BlogPostScopes;
use Innoboxrr\LaravelBlog\Enums\BlogPostStatus;
use Usamamuneerchaudhary\Commentify\Traits\Commentable;

class BlogPost extends Model
{

    use HasFactory,
        SoftDeletes,
        MetaOperations,
        ModelAppendsTrait,
        Auditable,
        BlogPostRelations,
        BlogPostStorage,
        BlogPostAssignment,
        BlogPostOperations,
        BlogPostScopes,
        BlogPostMutators,
        Commentable;
        
    protected $fillable = [
        'title',
        'slug',
        'status',
        'payload',
        'content',
        'blog_id',
        'published_at',
        'author_id',
    ];

    protected $creatable = [
        'title',
        'slug',
        'status',
        'content',
        'blog_id',
        'published_at',
        'author_id',
    ];

    protected $updatable = [
        'title',
        'slug',
        'status',
        'content',
        'published_at',
    ];

    protected $casts = [
        'status' => BlogPostStatus::class,
        'payload' => 'json',
        'published_at' => 'datetime',
    ];

    protected $protected_metas = [];

    protected $editable_metas = [
        'views',
        'meta_title',
        'meta_description',
        'meta_keywords',

        // Featured images
        'original_image',
        'thumbnail_image',
        'medium_image',
        'large_image',
        
        // Más etiquetas para seo
    ];

    public static $export_cols = [
        'title',
        'slug',
        'status',
        'content',
        'blog_id',
        'published_at',
    ];

    public static $loadable_relations = [
        'blog',
        'tags',
        'categories',
        'author',
    ];

    public static $loadable_counts = [
        'blog',
        'tags',
        'categories',
        'author',
    ];

    protected static function newFactory()
    {
        return \Innoboxrr\LaravelBlog\Database\Factories\BlogPostFactory::new();
    }
}