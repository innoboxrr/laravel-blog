<?php

namespace Innoboxrr\LaravelBlog\Models\Traits\Operations;

trait BlogOperations
{

    public function buildPayload()
    {
        return [
            'author' => [
                'name' => $this->meta('author_name'),
                'social' => [
                    'x-twitter' => $this->meta('author_social_x-twitter'),
                    'facebook' => $this->meta('author_social_facebook'),
                    'instagram' => $this->meta('author_social_instagram'),
                    'linkedin' => $this->meta('author_social_linkedin'),
                    'github' => $this->meta('author_social_github'),
                    'tiktok' => $this->meta('author_social_tiktok'),
                    'youtube' => $this->meta('author_social_youtube'),
                    'pinterest' => $this->meta('author_social_pinterest'),
                    'snapchat' => $this->meta('author_social_snapchat'),
                    'whatsapp' => $this->meta('author_social_whatsapp'),
                    'telegram' => $this->meta('author_social_telegram'),
                    'discord' => $this->meta('author_social_discord'),
                    'reddit' => $this->meta('author_social_reddit'),
                ]
            ],
            'blog' => [
                'social' => [
                    'x-twitter' => $this->meta('blog_social_x-twitter'),
                    'facebook' => $this->meta('blog_social_facebook'),
                    'instagram' => $this->meta('blog_social_instagram'),
                    'linkedin' => $this->meta('blog_social_linkedin'),
                    'github' => $this->meta('blog_social_github'),
                    'tiktok' => $this->meta('blog_social_tiktok'),
                    'youtube' => $this->meta('blog_social_youtube'),
                    'pinterest' => $this->meta('blog_social_pinterest'),
                    'snapchat' => $this->meta('blog_social_snapchat'),
                    'whatsapp' => $this->meta('blog_social_whatsapp'),
                    'telegram' => $this->meta('blog_social_telegram'),
                    'discord' => $this->meta('blog_social_discord'),
                    'reddit' => $this->meta('blog_social_reddit'),
                ]
            ]
        ];
    }

    public function updatePayload()
    {
        $this->payload = $this->buildPayload();
        return $this->save();
    }

    public static function resolveBlog($host, $slug = null)
    {
        return self::where('domain', $host)
            ->orWhere('slug', $slug)
            ->first();
    }

}
