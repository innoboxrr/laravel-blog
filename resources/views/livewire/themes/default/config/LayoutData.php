<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Innoboxrr\LaravelBlog\Models\BlogPost;
use Innoboxrr\Wirecomments\Models\Comment;

class LayoutData
{
    public static function toArray($component)
    {
        return [
            'title' => $component->blog->name,
            'logo' => $component->blog->logo,
            'favicon' => $component->blog->favicon,
            'appleTouchIcon' => $component->blog->apple_touch_icon,
            'favicon32' => $component->blog->favicon_32,
            'favicon16' => $component->blog->favicon_16,
            'safariMaskIcon' => $component->blog->safari_mask_icon,
            'description' => $component->blog->getPayload('blog.description'),
            'keywords' => $component->blog->getPayload('blog.keywords'),

            // General
            'categories' => $component->blog->categories()->where('parent_id', null)->get(),
            'tags' => $component->blog->tags()->get(),
            'latest_posts' => self::getLatestPosts($component),
            'latest_comments' => self::getLatestComments($component),
            'social_icons' => self::getSocialIcons(),
            
            // Author
            'author.name' => $component->blog->getPayload('author.name'),
            'author.socials' => $component->blog->getPayload('author.social'),
            'author.avatar' => self::getAuthorAvatarUrl($component),
            'author.title' => $component->blog->getPayload('author.title'),
            'author.company' => $component->blog->getPayload('author.company'),
            'author.resume' => $component->blog->getPayload('author.resume'),
            'author.contact_url' => $component->blog->getPayload('author.contact_url'),

            // Blog
            'blog.footer_text' => $component->blog->getPayload('blog.footer_text'),
            'blog.socias' => $component->blog->getPayload('blog.social'),

            // Advertisement
            'advertisement.type' => $component->blog->getPayload('advertisement.type'),
            'advertisement.url' => $component->blog->getPayload('advertisement.url'),
            'advertisement.alt' => $component->blog->getPayload('advertisement.alt'),
            'advertisement.title' => $component->blog->getPayload('advertisement.title'),
            'advertisement.image' => self::getAdvertisementImageUrl($component),
            'advertisement.code' => $component->blog->getPayload('advertisement.code'),

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

    public static function getLatestPosts($component)
    {
        $cacheKey = sprintf(
            'blog_%s_latest_posts',
            $component->blog->id
        );

        return Cache::remember(
            $cacheKey,
            now()->addMinutes(30),
            fn () => $component->blog->posts()
                ->select('id', 'title', 'slug', 'blog_id', 'published_at')
                ->where('status', 'published')
                ->latest('published_at')
                ->limit(3)
                ->get()
        );
    }

    public static function getLatestComments($component)
    {
        $cacheKey = 'blog_' . $component->blog->id . '_latest_comments';

        return Cache::remember(
            $cacheKey,
            now()->addMinutes(30),
            function () use ($component) {
                $postIds = $component->blog->posts()->pluck('id');

                if ($postIds->isEmpty()) {
                    return collect();
                }

                $comments = Comment::select('id', 'user_id', 'body', 'commentable_id', 'commentable_type', 'created_at')
                    ->where('commentable_type', BlogPost::class)
                    ->whereIn('commentable_id', $postIds)
                    ->with([
                        'user:id,name,avatar',
                        'commentable:id,title,slug,blog_id'
                    ])
                    ->latest('created_at')
                    ->limit(3)
                    ->get();

                // Inyecta avatar_url manualmente
                foreach ($comments as $comment) {
                    if ($comment->user) {
                        $avatar = $comment->user->avatar;

                        $comment->user->avatar_url = $avatar
                            ? Storage::disk('s3')->temporaryUrl($avatar, now()->addMinutes(5))
                            : 'https://i.imgur.com/WxNkK7J.png';
                    }
                }

                return $comments;
            }
        );
    }

    public static function getAuthorAvatarUrl($component)
    {
        $avatar = $component->blog->getPayload('author.avatar');

        return $avatar
            ? Storage::disk('s3')->temporaryUrl($avatar, now()->addMinutes(5))
            : 'https://i.imgur.com/WxNkK7J.png';
    }

    public static function getAdvertisementImageUrl($component)
    {
        $image = $component->blog->getPayload('advertisement.image');

        return $image
            ? Storage::disk('s3')->temporaryUrl($image, now()->addMinutes(5))
            : null;
    }

}
