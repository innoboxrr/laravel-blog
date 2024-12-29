<?php

namespace Innoboxrr\LaravelBlog\Support\Traits;

use Innoboxrr\LaravelBlog\Models\Blog;

trait Bloggable
{
    public function blogs()
    {
        return $this->morphToMany(Blog::class, 'bloggable');
    }

    public function blog()
    {
        return $this->morphOne(Blog::class, 'bloggable');
    }
}