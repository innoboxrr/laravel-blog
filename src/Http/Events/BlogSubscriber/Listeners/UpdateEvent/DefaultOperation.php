<?php

namespace Innoboxrr\LaravelBlog\Http\Events\BlogSubscriber\Listeners\UpdateEvent;

use Innoboxrr\LaravelBlog\Http\Events\BlogSubscriber\Events\UpdateEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DefaultOperation
{
    
    public function __construct()
    {
        //
    }

    public function handle(UpdateEvent $event)
    {
        //
    }

}
