<?php

namespace Innoboxrr\LaravelBlog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Innoboxrr\Traits\MetaOperations;
use Innoboxrr\Traits\ModelAppendsTrait;
use Innoboxrr\LaravelAudit\Support\Traits\Auditable;
use Innoboxrr\LaravelBlog\Models\Traits\Relations\BlogSubscriberRelations;
use Innoboxrr\LaravelBlog\Models\Traits\Storage\BlogSubscriberStorage;
use Innoboxrr\LaravelBlog\Models\Traits\Assignments\BlogSubscriberAssignment;
use Innoboxrr\LaravelBlog\Models\Traits\Operations\BlogSubscriberOperations;
use Innoboxrr\LaravelBlog\Models\Traits\Mutators\BlogSubscriberMutators;

class BlogSubscriber extends Model
{

    use HasFactory,
        SoftDeletes,
        MetaOperations,
        ModelAppendsTrait,
        Auditable,
        BlogSubscriberRelations,
        BlogSubscriberStorage,
        BlogSubscriberAssignment,
        BlogSubscriberOperations,
        BlogSubscriberMutators;
        
    protected $fillable = [
        'status',
        'email',
        'token',
        'verified_at',
        'name',
        'phone',
        'payload',
        'blog_id',
    ];

    protected $creatable = [
        'status',
        'email',
        'token',
        'name',
        'phone',
        'blog_id',
    ];

    protected $updatable = [
        'status',
        'email',
        'name',
        'phone',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
        'payload' => 'array',
    ];

    protected $protected_metas = [];

    protected $editable_metas = [
        'ip',
        'user_agent',
        'referrer',
    ];

    public static $export_cols = [
        'status',
        'email',
        'token',
        'verified_at',
        'name',
        'phone',
        'blog_id',
    ];

    public static $loadable_relations = [
        'metas',
        'blog'
    ];

    public static $loadable_counts = [
        'metas',
        'blog'
    ];

    protected static function newFactory()
    {
        return \Innoboxrr\LaravelBlog\Database\Factories\BlogSubscriberFactory::new();
    }

}
