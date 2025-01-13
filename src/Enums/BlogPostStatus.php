<?php

namespace Innoboxrr\LaravelBlog\Enums;

enum BlogPostStatus: string {
    case DRAFT = 'draft';
    case PUBLISHED = 'published';
    case ARCHIVED = 'archived';

    public static function toArray(): array
    {
        return [
            self::DRAFT,
            self::PUBLISHED,
            self::ARCHIVED,
        ];
    }
}