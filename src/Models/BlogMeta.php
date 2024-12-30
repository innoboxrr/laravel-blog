<?php

namespace Innoboxrr\LaravelBlog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BlogMeta extends Model
{

    use HasFactory;

    protected $guarded = [];

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }

}
