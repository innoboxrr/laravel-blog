<?php

namespace Innoboxrr\LaravelBlog\Http\Livewire;

use Innoboxrr\LaravelBlog\Http\Livewire\BaseLivewireComponent as Component;
use Livewire\WithPagination;
use Innoboxrr\LaravelBlog\Models\BlogPost;

class BlogIndex extends Component
{
    use WithPagination;



    public function render()
    {
        $posts = BlogPost::where('blog_id', $this->blog->id)
            ->paginate(10);


        return view("$this->themeView.blog-index-view", [
                'posts' => $posts
            ])
            ->extends($this->themeLayout)
            ->section('content');
    }
}
