<?php 

namespace Innoboxrr\LaravelBlog\Http\Livewire\Components;

use Innoboxrr\LaravelBlog\Http\Livewire\BaseLivewireComponent as Component;
use Innoboxrr\LaravelBlog\Models\BlogPost;

class RelatedPosts extends Component
{
    public BlogPost $post;

    public function getRelatedPostsProperty()
    {
        $query = BlogPost::where('blog_id', $this->post->blog_id)
            ->where('id', '!=', $this->post->id)
            ->published();

        // Prioridad por categoría compartida
        $categories = $this->post->categories->pluck('id');
        if ($categories->isNotEmpty()) {
            $query->whereHas('categories', function ($q) use ($categories) {
                $q->whereIn('blog_categories.id', $categories);
            });
        }

        return $query->orderByDesc('published_at')
            ->take(3)
            ->get();
    }


    public function render()
    {
        return $this->renderComponent('related-posts', [
            'relatedPosts' => $this->relatedPosts,
        ]);
    }
}
