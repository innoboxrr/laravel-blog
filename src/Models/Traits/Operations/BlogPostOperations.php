<?php

namespace Innoboxrr\LaravelBlog\Models\Traits\Operations;

use Illuminate\Http\Request;
use Innoboxrr\LaravelBlog\Services\BlogPost\FeaturedImageService;

trait BlogPostOperations
{

    public function buildPayload()
    {
        return [
            'stats' => [
                'views' => $this->meta('views'),
                'likes' => $this->meta('likes'),
                'comments' => $this->meta('comments'),
            ],
            'metas' => [
                'description' => $this->meta('description'),
                'keywords' => $this->meta('keywords'),
            ],
            'images' => [
                'original' => $this->meta('original_image'),
                'thumbnail' => $this->meta('thumbnail_image'),
                'medium' => $this->meta('medium_image'),
                'large' => $this->meta('large_image'),
            ],
            'share_buttons' => [
                'facebook' => (int) $this->meta('share_on_facebook'),
                'twitter' => (int) $this->meta('share_on_twitter'),
                'linkedin' => (int) $this->meta('share_on_linkedin'),
                // ..
            ],
            'playlist' => $this->meta('playlist'), // Allow to add a playlist to the post
            // Configurar
        ];
    }

    public function updatePayload()
    {
        $this->payload = $this->buildPayload();
        return $this->save();
    }
    
    public function uploadFeaturedImage(Request $request)
    {
        FeaturedImageService::uploadImage($request->file('featured_image'), $this);
    }

    public function generateFeaturedImage(Request $request)
    {
        FeaturedImageService::generateImage($this);
    }

    public function next()
    {
        return $this->blog->posts()
            ->where('id', '>', $this->id)
            ->orderBy('id', 'asc')
            ->first();
    }

    public function previous()
    {
        return $this->blog->posts()
            ->where('id', '<', $this->id)
            ->orderBy('id', 'desc')
            ->first();
    }
    
}