<?php

namespace Innoboxrr\LaravelBlog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Innoboxrr\Traits\MetaOperations;
use Innoboxrr\Traits\ModelAppendsTrait;
use Innoboxrr\LaravelBlog\Models\Traits\Relations\BlogRelations;
use Innoboxrr\LaravelBlog\Models\Traits\Storage\BlogStorage;
use Innoboxrr\LaravelBlog\Models\Traits\Assignments\BlogAssignment;
use Innoboxrr\LaravelBlog\Models\Traits\Operations\BlogOperations;
use Innoboxrr\LaravelBlog\Models\Traits\Mutators\BlogMutators;
use Innoboxrr\LaravelBlog\Enums\BlogStatus;

class Blog extends Model
{

    use HasFactory,
        SoftDeletes,
        MetaOperations,
        ModelAppendsTrait,
        BlogRelations,
        BlogStorage,
        BlogAssignment,
        BlogOperations,
        BlogMutators;
        
    protected $fillable = [
        'name',
        'slug',
        'status',
        'domain',
        'domain_verified_at',
        'payload',
        'bloggable_type',
        'bloggable_id',
    ];

    protected $creatable = [
        'name',
        'slug',
        'status',
        'domain',
        'bloggable_type',
        'bloggable_id',
    ];

    protected $updatable = [
        'name',
        'slug',
        'status',
        'domain',
    ];

    protected $casts = [
        'status' => BlogStatus::class,
    ];

    protected $protected_metas = [];

    protected $editable_metas = [];

    public static $export_cols = [
        'name',
        'slug',
        'status',
        'domain',
        'domain_verified_at',
        'bloggable_type',
        'bloggable_id',
    ];

    public static $loadable_relations = [
        'bloggable',
        'categories',
        'tags',
        'posts',
    ];

    public static $loadable_counts = [
        'bloggable',
        'categories',
        'tags',
        'posts',
    ];

    protected static function newFactory()
    {
        return \Innoboxrr\LaravelBlog\Database\Factories\BlogFactory::new();
    }

}