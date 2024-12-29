<?php

namespace Innoboxrr\LaravelBlog\Models\Traits\Relations;

use Innoboxrr\LaravelBlog\Models\Blog;
use Innoboxrr\LaravelBlog\Models\BlogPost;
// use \Znck\Eloquent\Traits\BelongsToThrough; // Docs: https://github.com/staudenmeir/belongs-to-through
// use \Staudenmeir\EloquentHasManyDeep\HasRelationships; // Docs: https://github.com/staudenmeir/eloquent-has-many-deep

trait BlogTagRelations
{
    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }

    public function posts()
    {
        return $this->belongsToMany(
            BlogPost::class, 
            'blog_post_tags', 
            'blog_tag_id', 
            'blog_post_id'
        );
    }
}