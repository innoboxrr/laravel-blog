<?php

namespace Innoboxrr\LaravelBlog\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Innoboxrr\LaravelBlog\Models\BlogPost;

class BlogIndex extends Component
{
    use WithPagination;

    public $blog;

    public function mount()
    {
        $this->blog = view()->shared('currentBlog');
    }

    public function render()
    {
        $posts = BlogPost::where('blog_id', $this->blog->id)
            ->paginate(10);

        $theme = $this->blog->theme;

        return view("themes.$theme.views.blog-index-view")
            ->extends("themes.$theme.layout.app")
            ->section('content');
    }
}
