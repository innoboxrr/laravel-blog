<?php

namespace Innoboxrr\LaravelBlog\Http\Livewire;

use Livewire\Component;

class BaseLivewireComponent extends Component
{
    public $blog;
    public $theme;
    public $themeView;
    public $themeLayout;

    public function boot()
    {
        $this->blog = view()->shared('currentBlog');
        $this->theme = view()->shared('theme');
        $this->themeView = "laravel-blog::livewire.themes.$this->theme.views";
        $this->themeLayout = "laravel-blog::livewire.themes.$this->theme.layout.app";

    }
}