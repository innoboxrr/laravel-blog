<?php

namespace Innoboxrr\LaravelBlog\Models\Traits\Operations;

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
                'original' => '',
                'thumbnail' => '',
                'medium' => '',
                'large' => '',
            ],
            'share_buttons' => [
                'facebook' => (int) $this->meta('share_on_facebook'),
                'twitter' => (int) $this->meta('share_on_twitter'),
                'linkedin' => (int) $this->meta('share_on_linkedin'),
                // ..
            ],
            // Configurar
        ];
    }

    public function updatePayload()
    {
        $this->payload = $this->buildPayload();
        return $this->save();
    }
}