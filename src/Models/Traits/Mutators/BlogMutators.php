<?php

namespace Innoboxrr\LaravelBlog\Models\Traits\Mutators;

trait BlogMutators
{

	public function getUrlAttribute()
    {
        $domain = $this->domain;

        if (!str_starts_with($domain, 'http://') && !str_starts_with($domain, 'https://')) {
            $domain = 'https://' . $domain;
        }

        return parse_url($domain);
    }

}