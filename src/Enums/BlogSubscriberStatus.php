<?php

namespace Innoboxrr\LaravelBlog\Enums;

enum BlogSubscriberStatus: string {
    case PENDING = 'pending';
    case ACTIVE = 'active';
    case UNSUSCRIBED = 'unsubscribed';
    case BLOCKED = 'blocked';
}