<?php

namespace Innoboxrr\LaravelBlog\Http\Livewire;

use Innoboxrr\LaravelBlog\Http\Livewire\BaseLivewireComponent as Component;
use Livewire\WithPagination;
use Innoboxrr\LaravelBlog\Models\BlogPost;

class BlogIndex extends Component
{
    use WithPagination;

    public $search;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function mount()
    {
        
    }

    private function getPosts()
    {
        return BlogPost::where('blog_id', $this->blog->id)
            ->paginate(10);
    }

    public function render()
    {
        return $this->renderView('index', [
            'posts' => $this->getPosts(),
        ]);
    }
}
