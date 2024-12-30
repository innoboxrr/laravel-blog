<?php

namespace Innoboxrr\LaravelBlog\Support\Traits;

use Innoboxrr\LaravelBlog\Support\DTOs\BlogDto;
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

    public function hasBlog()
    {
        return $this->blog()->exists();
    }

    public function createBlog(BlogDto $blogDto)
    {
        $blog = new Blog;
        return $blog->createModel($blogDto);
    }
}