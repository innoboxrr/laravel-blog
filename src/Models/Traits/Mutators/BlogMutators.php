<?php

namespace Innoboxrr\LaravelBlog\Models\Traits\Mutators;

trait BlogMutators
{
    public function getThemeAttribute()
    {
        return $this->getPayload('blog.theme', 'default');
    }

	public function getUrlAttribute()
    {
        $domain = $this->domain;

        if (!str_starts_with($domain, 'http://') && !str_starts_with($domain, 'https://')) {
            $domain = 'https://' . $domain;
        }

        return parse_url($domain);
    }

}