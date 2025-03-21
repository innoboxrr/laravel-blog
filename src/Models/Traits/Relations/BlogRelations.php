<?php

namespace Innoboxrr\LaravelBlog\Models\Traits\Relations;

use Innoboxrr\LaravelBlog\Models\BlogMeta;
use Innoboxrr\LaravelBlog\Models\BlogCategory;
use Innoboxrr\LaravelBlog\Models\BlogTag;
use Innoboxrr\LaravelBlog\Models\BlogPost;
use Innoboxrr\LaravelBlog\Models\BlogSubscriber;
// use \Znck\Eloquent\Traits\BelongsToThrough; // Docs: https://github.com/staudenmeir/belongs-to-through
// use \Staudenmeir\EloquentHasManyDeep\HasRelationships; // Docs: https://github.com/staudenmeir/eloquent-has-many-deep

trait BlogRelations
{

    public function metas()
    {
        return $this->hasMany(BlogMeta::class);
    }

    public function bloggable()
    {
        return $this->morphTo();
    }

    public function categories()
    {
        return $this->hasMany(BlogCategory::class);
    }

    public function tags()
    {
        return $this->hasMany(BlogTag::class);
    }

    public function posts()
    {
        return $this->hasMany(BlogPost::class);
    }

    public function subscribers()
    {
        return $this->hasMany(BlogSubscriber::class);
    }
}