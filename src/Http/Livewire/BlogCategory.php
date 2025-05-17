<?php

namespace Innoboxrr\LaravelBlog\Http\Livewire;

use Innoboxrr\LaravelBlog\Http\Livewire\BaseLivewireComponent as Component;
use Innoboxrr\LaravelBlog\Models\BlogCategory as BlogCategoryModel;

class BlogCategory extends Component
{
    public $category;

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
            'posts' => $this->category->posts()->paginate(10),
        ]);
    }
}
