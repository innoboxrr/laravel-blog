<?php

namespace Innoboxrr\LaravelBlog\Http\Livewire\Components;

use Innoboxrr\LaravelBlog\Http\Livewire\BaseLivewireComponent as Component;
use Innoboxrr\LaravelBlog\Models\BlogPost;

class SharePost extends Component
{
    public BlogPost $post;

    public string $postUrl;

    public function mount(BlogPost $post)
    {
        $this->postUrl = blog_post_route($post);
    }

    public function render()
    {
        return $this->renderComponent('share-post', [
            'postUrl' => $this->postUrl,
        ]);
    }
}
