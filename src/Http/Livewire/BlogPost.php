<?php

namespace Innoboxrr\LaravelBlog\Http\Livewire;

use Innoboxrr\LaravelBlog\Http\Livewire\BaseLivewireComponent as Component;
use Innoboxrr\LaravelBlog\Models\BlogPost as BlogPostModel;

class BlogPost extends Component
{
    public $post;

    public function mount($post)
    {
        $this->post = BlogPostModel::where(function ($query) use ($post) {
                $query->where('slug', $post)
                    ->orWhere('id', $post);
            })
            ->where('blog_id', $this->blog->id)
            ->firstOrFail();
    }

    public function render()
    {
        return $this->renderView('post', [
            'post' => $this->post,
        ]);
    }
}
