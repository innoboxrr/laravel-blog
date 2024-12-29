<?php

namespace Innoboxrr\LaravelBlog\Http\Events\BlogCategory\Listeners\ForceDeleteEvent;

use Innoboxrr\LaravelBlog\Http\Events\BlogCategory\Events\ForceDeleteEvent;
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
