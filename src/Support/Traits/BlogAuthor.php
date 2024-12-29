<?php

namespace Innoboxrr\LaravelBlog\Support\Traits;

use Innoboxrr\LaravelBlog\Models\BlogPost;

trait BlogAuthor
{
    public function blogPosts()
    {
        return $this->hasMany(BlogPost::class, 'author_id');
    }
}