<?php

namespace Innoboxrr\LaravelBlog\Http\Livewire\Components;

use Innoboxrr\LaravelBlog\Http\Livewire\BaseLivewireComponent as Component;
use Innoboxrr\LaravelBlog\Models\BlogSubscriber;

class SubscribeComponent extends Component
{
    public $email;

    public function subscribe()
    {
        $this->validate(['email' => 'required|email']);
        BlogSubscriber::create(['email' => $this->email]);

        session()->flash('message', '¡Gracias por suscribirte!');
        $this->reset('email');
    }

    public function render()
    {
        return view('themes.default.components.subscribe-component');
    }
}
