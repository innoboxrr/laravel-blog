<?php

namespace Innoboxrr\LaravelBlog\Http\Livewire;

use Innoboxrr\LaravelBlog\Http\Livewire\BaseLivewireComponent as Component;
use Innoboxrr\LaravelBlog\Models\BlogPost as BlogPostModel;

class BlogPost extends Component
{
    public $post;

    public function mount($postSlug)
    {
        $this->post = BlogPostModel::where('slug', $postSlug)
            ->where('blog_id', $this->blog->id)
            ->firstOrFail();
    }

    public function render()
    {
        return view("$this->themeView.blog-post-view")
            ->extends($this->themeLayout)
            ->section('content');
    }
}
