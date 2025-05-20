<?php

namespace Innoboxrr\LaravelBlog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Innoboxrr\Traits\MetaOperations;
use Innoboxrr\Traits\ModelAppendsTrait;
use Innoboxrr\LaravelAudit\Support\Traits\Auditable;
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
        Auditable,
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
        'payload' => 'array',
    ];

    protected $protected_metas = [];

    protected $editable_metas = [
        'author_name',
        'author_title',
        'author_company',
        'author_bio',
        'author_avatar',
        'author_resume',
        'author_contact_url',
        'author_email',
        'author_social_x',
        'author_social_facebook',
        'author_social_instagram',
        'author_social_linkedin',
        'author_social_github',
        'author_social_tiktok',
        'author_social_youtube',
        'author_social_pinterest',
        'author_social_snapchat',
        'author_social_whatsapp',
        'author_social_telegram',
        'author_social_discord',
        'author_social_reddit',
        'blog_theme',
        'blog_allow_comments',
        'blog_allow_subscriptions',
        'blog_footer_text',
        'blog_social_x',
        'blog_social_facebook',
        'blog_social_instagram',
        'blog_social_linkedin',
        'blog_social_github',
        'blog_social_tiktok',
        'blog_social_youtube',
        'blog_social_pinterest',
        'blog_social_snapchat',
        'blog_social_whatsapp',
        'blog_social_telegram',
        'blog_social_discord',
        'blog_social_reddit',
        'advertisement_title',
        'advertisement_image',
        'advertisement_url',
        'advertisement_description',
        'advertisement_alt',
        'advertisement_code',
    ];

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