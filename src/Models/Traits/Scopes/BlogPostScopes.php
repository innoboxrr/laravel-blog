<?php

namespace Innoboxrr\LaravelBlog\Models\Traits\Scopes;

trait BlogPostScopes
{
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }
}