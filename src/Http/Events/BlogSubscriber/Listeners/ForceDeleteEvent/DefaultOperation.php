<?php

namespace Innoboxrr\LaravelBlog\Http\Events\BlogSubscriber\Listeners\ForceDeleteEvent;

use Innoboxrr\LaravelBlog\Http\Events\BlogSubscriber\Events\ForceDeleteEvent;
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
