<?php

namespace Innoboxrr\LaravelBlog\Http\Livewire;

use Innoboxrr\LaravelBlog\Http\Livewire\BaseLivewireComponent as Component;
use Innoboxrr\LaravelBlog\Models\BlogTag as BlogTagModel;

class BlogTag extends Component
{
    public $tag;

    public function mount($tag)
    {
        $this->tag = BlogTagModel::where(function ($query) use ($tag) {
                $query->where('slug', $tag)
                    ->orWhere('id', $tag);
            })
            ->where('blog_id', $this->blog->id)
            ->firstOrFail();
    }

    public function render()
    {
        return $this->renderView('tag', [
            'tag' => $this->tag,
            'posts' => $this->tag->posts()->paginate(10),
        ]);
    }
}
