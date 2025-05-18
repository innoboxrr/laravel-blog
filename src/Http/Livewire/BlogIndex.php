<?php

namespace Innoboxrr\LaravelBlog\Http\Livewire;

use Innoboxrr\LaravelBlog\Http\Livewire\BaseLivewireComponent as Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Collection;
use Innoboxrr\LaravelBlog\Models\BlogPost;

class BlogIndex extends Component
{
    use WithPagination;

    public $search;

    public $perPage = 1;

    public $page = 20;

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1], 
    ];

    private function getPosts()
    {
        return BlogPost::where('blog_id', $this->blog->id)
            ->paginate($this->perPage);
    }

    public function getFeaturedPosts(): Collection
    {
        $cacheKey = "blog:{$this->blog->id}:featured-posts";

        return Cache::remember($cacheKey, now()->addMinutes(15), function () {
            $featured = BlogPost::where('blog_id', $this->blog->id)
                ->where('featured', true)
                ->orderByDesc('published_at')
                ->take(10)
                ->get();

            $count = $featured->count();

            if ($count < 5) {
                $missing = 5 - $count;

                $filler = BlogPost::where('blog_id', $this->blog->id)
                    ->where(function ($query) {
                        $query->where('featured', false)->orWhereNull('featured');
                    })
                    ->orderByDesc('published_at')
                    ->take($missing)
                    ->get();

                $featured = $featured->merge($filler);
            }

            return $featured->shuffle()->take(5)->values();
        });
    }

    public function render()
    {
        return $this->renderView('index', [
            'posts' => $this->getPosts(),
            'featuredPosts' => $this->getFeaturedPosts(),
        ]);
    }
}
