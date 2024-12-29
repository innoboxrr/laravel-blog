<?php

namespace Innoboxrr\LaravelBlog\Http\Events\BlogPost\Listeners\CreateEvent;

use Innoboxrr\LaravelBlog\Http\Events\BlogPost\Events\CreateEvent;
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
