<?php

namespace Innoboxrr\LaravelBlog\Http\Livewire\Components;

use Innoboxrr\LaravelBlog\Http\Livewire\BaseLivewireComponent as Component;
use Innoboxrr\LaravelBlog\Models\BlogPost;

class PostAboutAuthor extends Component
{
    public BlogPost $post;

    public function render()
    {
        return $this->renderComponent('post-about-author', [
            'author' => $this->getAuthorData(),
            'post' => $this->post,
        ]);
    }

    protected function getAuthorData(): array
    {
        $blog = $this->blog;
        $payload = $blog->getPayload('author');

        return [
            'name' => $payload['name'] ?? 'Anonymous',
            'bio' => $payload['bio'] ?? '',
            'avatar' => $this->resolveAvatar($payload['avatar'] ?? null, $payload['name']),
            'social' => $payload['social'] ?? [],
        ];
    }

    protected function resolveAvatar(?string $avatar, ?string $name): string
    {
        if ($avatar) {
            return $avatar;
        }

        if ($name) {
            $hash = md5(strtolower(trim($name)));
            return "https://www.gravatar.com/avatar/{$hash}?s=150&d=mp";
        }

        return 'https://www.gravatar.com/avatar/?s=150&d=mp';
    }
}
