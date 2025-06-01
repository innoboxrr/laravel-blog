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

    public function getLogoAttribute()
    {
        $logo = $this->getPayload('blog.logo');
        if( empty($logo) ) {
            return config('laravel-blog.layout_data.logo');
        } else {
            return url($logo);
        }
    }

    public function getFaviconAttribute()
    {
        $favicon = $this->getPayload('blog.favicon');
        if( empty($favicon) ) {
            return config('laravel-blog.layout_data.favicon');
        } else {
            return url($favicon);
        }
    }

    public function getAppleTouchIconAttribute()
    {
        $appleTouchIcon = $this->getPayload('blog.apple_touch_icon');
        if( empty($appleTouchIcon) ) {
            return config('laravel-blog.layout_data.appleTouchIcon');
        } else {
            return url($appleTouchIcon);
        }
    }

    public function getFavicon32Attribute()
    {
        $favicon32 = $this->getPayload('blog.favicon_32');
        if( empty($favicon32) ) {
            return config('laravel-blog.layout_data.favicon32');
        } else {
            return url($favicon32);
        }
    }

    public function getFavicon16Attribute()
    {
        $favicon16 = $this->getPayload('blog.favicon_16');
        if( empty($favicon16) ) {
            return config('laravel-blog.layout_data.favicon16');
        } else {
            return url($favicon16);
        }
    }

    public function getSafariMaskIconAttribute()
    {
        $safariMaskIcon = $this->getPayload('blog.safari_mask_icon');
        if( empty($safariMaskIcon) ) {
            return config('laravel-blog.layout_data.safariMaskIcon');
        } else {
            return url($safariMaskIcon);
        }
    }

}