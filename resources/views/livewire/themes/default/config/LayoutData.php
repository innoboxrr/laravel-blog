<?php

class LayoutData
{
    public static function toArray($component)
    {
        return [
            // General
            'categories' => $component->blog->categories()->where('parent_id', null)->get(),
            'tags' => $component->blog->tags()->get(),
            'social_icons' => self::getSocialIcons(),
            
            // Author
            'author.name' => $component->blog->getPayload('author.name'),
            'author.socials' => $component->blog->getPayload('author.social'),

            // Blog
            'blog.footer_text' => $component->blog->getPayload('blog.footer_text'),
            'blog.socias' => $component->blog->getPayload('blog.social'),
        ];
    }

    public static function getSocialIcons()
    {
        return [
            'x-twitter' => 'fa-x-twitter',
            'facebook' => 'fa-facebook-f',
            'instagram' => 'fa-instagram',
            'linkedin' => 'fa-linkedin-in',
            'github' => 'fa-github',
            'tiktok' => 'fa-tiktok',
            'youtube' => 'fa-youtube',
            'pinterest' => 'fa-pinterest-p',
            'snapchat' => 'fa-snapchat-ghost',
            'whatsapp' => 'fa-whatsapp',
            'telegram' => 'fa-telegram-plane',
            'discord' => 'fa-discord',
            'reddit' => 'fa-reddit-alien',
        ];
    }
}
