<?php 

namespace Innoboxrr\LaravelBlog\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Queue\ShouldQueue;
use Innoboxrr\Wirecomments\Models\Comment;

class BlogUserRegisteres
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;

    public $blogId;

    public function __construct($user, $blogId)
    {
        $this->user = $user;
        $this->blogId = $blogId;
    }
}
