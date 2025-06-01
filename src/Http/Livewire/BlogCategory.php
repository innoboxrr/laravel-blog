<?php

namespace Innoboxrr\LaravelBlog\Http\Livewire;

use Innoboxrr\LaravelBlog\Http\Livewire\BaseLivewireComponent as Component;
use Innoboxrr\LaravelBlog\Models\BlogCategory as BlogCategoryModel;
use Livewire\WithPagination;

class BlogCategory extends Component
{
    use WithPagination;

    public $category;

    public $perPage = 20;

    protected $queryString = [
        'page' => ['except' => 1], 
    ];

    public function mount($category)
    {
        $this->category = BlogCategoryModel::where(function ($query) use ($category) {
                $query->where('slug', $category)
                    ->orWhere('id', $category);
            })
            ->where('blog_id', $this->blog->id)
            ->firstOrFail();
    }

    public function render()
    {
        return $this->renderView('category', [
            'category' => $this->category,
            'posts' => $this->category->posts()
                ->orderByDesc('published_at')
                ->paginate(10),
            'asideData' => $this->getLayoutData()['layoutData'],
        ]);
    }
}
