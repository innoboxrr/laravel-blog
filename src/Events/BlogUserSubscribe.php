<?php 

namespace Innoboxrr\LaravelBlog\Events;

use Innoboxrr\LaravelBlog\Models\BlogSubscriber;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Queue\ShouldQueue;
use Innoboxrr\Wirecomments\Models\Comment;

class BlogUserSubscribe
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $subscriber;

    public function __construct(BlogSubscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }
}
