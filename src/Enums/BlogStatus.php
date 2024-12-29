<?php

namespace Innoboxrr\LaravelBlog\Enums;

enum BlogStatus: string {
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
}