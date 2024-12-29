<?php

namespace Innoboxrr\LaravelBlog\Http\Events\BlogPost\Listeners\ForceDeleteEvent;

use Innoboxrr\LaravelBlog\Http\Events\BlogPost\Events\ForceDeleteEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DefaultOperation
{
    
    public function __construct()
    {
        //
    }

    public function handle(ForceDeleteEvent $event)
    {
        //
    }

}
