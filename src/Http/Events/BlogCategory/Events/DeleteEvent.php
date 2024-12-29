<?php

namespace Innoboxrr\LaravelBlog\Http\Events\BlogCategory\Events;

use Innoboxrr\LaravelBlog\Models\BlogCategory;
use Illuminate\Support\Facades\App;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DeleteEvent
{

    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $blogCategory;
    public $data;
    public $response;
    public $locale;

    public function __construct(BlogCategory $blogCategory, array $data, $response, $locale = 'en')
    {
        $this->blogCategory = $blogCategory;
        $this->data = $data;
        $this->response = $response;
        $this->locale = $locale;
        App::setLocale($this->locale);
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }

}