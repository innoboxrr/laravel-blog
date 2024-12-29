<?php

namespace Innoboxrr\LaravelBlog\Http\Events\BlogPost\Listeners\DeleteEvent;

use Innoboxrr\LaravelBlog\Http\Events\BlogPost\Events\DeleteEvent;
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
