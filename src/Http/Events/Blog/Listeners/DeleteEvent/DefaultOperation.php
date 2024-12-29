<?php

namespace Innoboxrr\LaravelBlog\Http\Events\Blog\Listeners\DeleteEvent;

use Innoboxrr\LaravelBlog\Http\Events\Blog\Events\DeleteEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DefaultOperation
{
    
    public function __construct()
    {
        //
    }

    public function handle(DeleteEvent $event)
    {
        //
    }

}
