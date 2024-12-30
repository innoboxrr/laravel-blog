<?php

namespace Innoboxrr\LaravelBlog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BlogSubscriberMeta extends Model
{

    use HasFactory;

    protected $guarded = [];

    public function blogSubscriber()
    {
        return $this->belongsTo(BlogSubscriber::class);
    }

}
