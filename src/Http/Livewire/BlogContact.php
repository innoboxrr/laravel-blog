<?php

namespace Innoboxrr\LaravelBlog\Http\Livewire;

use Innoboxrr\LaravelBlog\Http\Livewire\BaseLivewireComponent as Component;

class BlogContact extends Component
{
    public function render()
    {
        return $this->renderView('contact');
    }
}
