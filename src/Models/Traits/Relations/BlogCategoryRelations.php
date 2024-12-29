<?php

namespace Innoboxrr\LaravelBlog\Models\Traits\Relations;

use Innoboxrr\LaravelBlog\Models\Blog;
use Innoboxrr\LaravelBlog\Models\BlogPost;
// use \Znck\Eloquent\Traits\BelongsToThrough; // Docs: https://github.com/staudenmeir/belongs-to-through
// use \Staudenmeir\EloquentHasManyDeep\HasRelationships; // Docs: https://github.com/staudenmeir/eloquent-has-many-deep

trait BlogCategoryRelations
{
    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function posts()
    {
        return $this->belongsToMany(
            BlogPost::class, 
            'blog_category_post', 
            'blog_category_id', 
            'blog_post_id'
        );
    }
}