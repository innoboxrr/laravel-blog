<?php

namespace Innoboxrr\LaravelBlog\Models\Traits\Mutators;

trait BlogPostMutators
{
	public function getThumbnailAttribute()
    {   
        return $this->getPayload('images.thumbnail') ?? 'https://picsum.photos/seed/' . $this->id . '/300/200';
    }

    public function getPlaylistAttribute()
    {   
        $rawPlaylist = $this->getPayload('playlist', []);
        return is_array($rawPlaylist) 
            ? $rawPlaylist 
            : json_decode($rawPlaylist, true) ?? [];
    }

    public function getCommentsCountAttribute(): int
    {
        return $this->getPayload('stats.comments') ?? 0;
    }
}