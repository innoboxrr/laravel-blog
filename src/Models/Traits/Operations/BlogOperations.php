<?php

namespace Innoboxrr\LaravelBlog\Models\Traits\Operations;

trait BlogOperations
{

    public function buildPayload()
    {
        return [
            'author' => [
                'name' => $this->meta('author_name'),
                'title' => $this->meta('author_title'),
                'company' => $this->meta('author_company'),
                'bio' => $this->meta('author_bio'),
                'avatar' => $this->meta('author_avatar'),
                'resume' => $this->meta('author_resume'),
                'contact_url' => $this->meta('author_contact_url'),
                'email' => $this->meta('author_email'),

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
                'theme' => $this->meta('blog_theme', 'default'),
                'allow_comments' => (int) $this->meta('blog_allow_comments', 1),
                'allow_subscriptions' => (int) $this->meta('blog_allow_subscriptions', 1),
                'footer_text' => $this->meta('blog_footer_text'),
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
            ],

            'advertisement' => [
                'type' => $this->meta('advertisement_type'),
                'title' => $this->meta('advertisement_title'),
                'image' => $this->meta('advertisement_image'),
                'url' => $this->meta('advertisement_url'),
                'description' => $this->meta('advertisement_description'),
                'alt' => $this->meta('advertisement_alt'),
                'code' => $this->meta('advertisement_code'),
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
