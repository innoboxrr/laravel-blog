<?php

namespace Innoboxrr\LaravelBlog\Enums;

enum BlogPostStatus: string {
    case DRAFT = 'draft';
    case PUBLISHED = 'published';
    case ARCHIVED = 'archived';
}