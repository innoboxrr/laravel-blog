<?php

namespace Innoboxrr\LaravelBlog\Models\Traits\Mutators;

trait BlogPostMutators
{

	public function getThumbnailAttribute()
    {   
        return $this->getPayload('images.thumbnail') ?? 'https://picsum.photos/seed/' . $this->id . '/300/200';
    }


}