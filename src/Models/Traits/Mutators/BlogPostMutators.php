<?php

namespace Innoboxrr\LaravelBlog\Models\Traits\Mutators;

trait BlogPostMutators
{

    public function getOriginalImageAttribute()
    {
        $value = $this->getPayload('images.original', 'https://picsum.photos/seed/' . $this->id . '/800/600');

        if(str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            return $value;
        } else {
            return url($value);
        }
    }

	public function getThumbnailImageAttribute()
    {
        $value = $this->getPayload('images.thumbnail', 'https://picsum.photos/seed/' . $this->id . '/300/200');

        if(str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            return $value;
        } else {
            return url($value);
        }
    }

    public function getLargeImageAttribute()
    {
        $value = $this->getPayload('images.large', 'https://picsum.photos/seed/' . $this->id . '/1024/768');

        if(str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            return $value;
        } else {
            return url($value);
        }
    }

    public function getMediumImageAttribute()
    {
        $value = $this->getPayload('images.medium', 'https://picsum.photos/seed/' . $this->id . '/600/400');

        if(str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            return $value;
        } else {
            return url($value);
        }
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