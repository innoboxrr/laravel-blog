<?php

namespace Innoboxrr\LaravelBlog\Http\Events\BlogPost\Listeners\ExportEvent;

use Innoboxrr\LaravelBlog\Notifications\BlogPost\ExportNotification;
use Innoboxrr\LaravelBlog\Http\Events\BlogPost\Events\ExportEvent;
use Illuminate\Support\Facades\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendExportNotification
{

    public function __construct()
    {
        //
    }

    public function handle(ExportEvent $event)
    {
        $event->user->notify((new ExportNotification($event->data))->locale($event->locale));
    }

}