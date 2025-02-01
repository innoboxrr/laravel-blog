<?php

namespace Innoboxrr\LaravelBlog\Models\Traits\Relations;

use Innoboxrr\LaravelBlog\Models\Blog;
use Innoboxrr\LaravelBlog\Models\BlogPostMeta;
use Innoboxrr\LaravelBlog\Models\BlogCategory;
use Innoboxrr\LaravelBlog\Models\BlogTag;

// use \Znck\Eloquent\Traits\BelongsToThrough; // Docs: https://github.com/staudenmeir/belongs-to-through
// use \Staudenmeir\EloquentHasManyDeep\HasRelationships; // Docs: https://github.com/staudenmeir/eloquent-has-many-deep

trait BlogPostRelations
{

    public function metas()
    {
        return $this->hasMany(BlogPostMeta::class);
    }

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }

    public function tags()
    {
        return $this->belongsToMany(
            BlogTag::class, 
            'blog_post_tags', 
            'blog_post_id', 
            'blog_tag_id'
        );
    }

    public function categories()
    {
        return $this->belongsToMany(
            BlogCategory::class, 
            'blog_category_post', 
            'blog_post_id', 
            'blog_category_id'
        );
    }

    public function author()
    {
        return $this->belongsTo(config('laravel-blog.author_class'), 'author_id');
    }
}