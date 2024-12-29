<?php

namespace Innoboxrr\LaravelBlog\Http\Events\Blog\Listeners\CreateEvent;

use Innoboxrr\LaravelBlog\Http\Events\Blog\Events\CreateEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DefaultOperation
{
    
    public function __construct()
    {
        //
    }

    public function handle(CreateEvent $event)
    {
        //
    }

}
