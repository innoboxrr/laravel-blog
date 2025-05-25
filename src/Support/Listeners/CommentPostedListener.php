<?php

namespace Innoboxrr\LaravelBlog\Support\Listeners;

use Innoboxrr\Wirecomments\Events\CommentPosted;
use Illuminate\Support\Facades\Cache;
use Innoboxrr\LaravelBlog\Models\BlogPost;

class CommentPostedListener
{
    public function handle(CommentPosted $event)
    {
        $post = $event->comment->commentable;

        $post->metas()->updateOrCreate(
            ['key' => 'comments'],
            ['value' => $post->comments()->count()]
        );

        $post->updatePayload();
    }
}
