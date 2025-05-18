<?php 

namespace Innoboxrr\LaravelBlog\Http\Livewire\Components;

use Innoboxrr\LaravelBlog\Http\Livewire\BaseLivewireComponent as Component;
use Innoboxrr\LaravelBlog\Models\BlogPost;

class BlogPostCard extends Component
{
    public BlogPost $post;
    public string $color = 'blue'; // acepta blue, red, yellow, green

    public function render()
    {
        return $this->renderComponent('blog-post-card', [
            'post' => $this->post,
            'category' => $this->post->categories->first(),
            'color' => $this->color,
        ]);
    }
}
