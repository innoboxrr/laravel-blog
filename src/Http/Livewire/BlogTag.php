<?php

namespace Innoboxrr\LaravelBlog\Http\Livewire;

use Innoboxrr\LaravelBlog\Http\Livewire\BaseLivewireComponent as Component;
use Innoboxrr\LaravelBlog\Models\BlogTag as BlogTagModel;
use Livewire\WithPagination;

class BlogTag extends Component
{
    use WithPagination;

    public $tag;

    public $perPage = 20;

    protected $queryString = [
        'page' => ['except' => 1],
    ];

    public function mount($tag)
    {
        $this->tag = BlogTagModel::where(function ($query) use ($tag) {
                $query->where('id', $tag);
            })
            ->where('blog_id', $this->blog->id)
            ->firstOrFail();
    }

    public function render()
    {
        return $this->renderView('tag', [
            'tag' => $this->tag,
            'posts' => $this->tag->posts()
                ->orderByDesc('published_at')
                ->paginate($this->perPage),
            'asideData' => $this->getLayoutData()['layoutData'],
        ]);
    }
}
