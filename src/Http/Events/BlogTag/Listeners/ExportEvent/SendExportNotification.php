<?php

namespace Innoboxrr\LaravelBlog\Http\Events\BlogTag\Listeners\ExportEvent;

use Innoboxrr\LaravelBlog\Notifications\BlogTag\ExportNotification;
use Innoboxrr\LaravelBlog\Http\Events\BlogTag\Events\ExportEvent;
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