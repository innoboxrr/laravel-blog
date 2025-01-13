<?php

namespace Innoboxrr\LaravelBlog\Http\Livewire;

use Livewire\Component;
use Innoboxrr\LaravelBlog\Models\BlogPost as BlogPostModel;

class BlogPost extends Component
{
    public $post;
    public $blog;

    public function mount($postSlug)
    {
        $this->blog = view()->shared('currentBlog');
        $this->post = BlogPostModel::where('slug', $postSlug)
            ->where('blog_id', $this->blog->id)
            ->firstOrFail();
    }

    public function render()
    {
        $theme = $this->blog->theme;

        return view("themes.$theme.views.blog-post-view")
            ->extends("themes.$theme.layout.app")
            ->section('content');
    }
}
