<?php

namespace Innoboxrr\LaravelBlog\Models\Traits\Relations;

use Innoboxrr\LaravelBlog\Models\BlogSubscriberMeta;
use Innoboxrr\LaravelBlog\Models\Blog;
// use \Znck\Eloquent\Traits\BelongsToThrough; // Docs: https://github.com/staudenmeir/belongs-to-through
// use \Staudenmeir\EloquentHasManyDeep\HasRelationships; // Docs: https://github.com/staudenmeir/eloquent-has-many-deep

trait BlogSubscriberRelations
{
    public function metas()
    {
        return $this->hasMany(BlogSubscriberMeta::class);
    }

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
}