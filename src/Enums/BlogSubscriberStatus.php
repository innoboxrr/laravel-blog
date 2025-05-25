<?php

namespace Innoboxrr\LaravelBlog\Enums;

enum BlogSubscriberStatus: string {
    case PENDING = 'pending';
    case VERIFIED = 'verified';
    case UNSUSCRIBED = 'unsubscribed';
    case BLOCKED = 'blocked';
}