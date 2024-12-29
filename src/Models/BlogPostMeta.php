<?php

namespace Innoboxrr\LaravelBlog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BlogPostMeta extends Model
{

    use HasFactory;

    protected $guarded = [];

    public function blogPost()
    {
        return $this->belongsTo(BlogPost::class);
    }

}
