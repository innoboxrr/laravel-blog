<?php

namespace Innoboxrr\LaravelBlog\Http\Livewire\Components;

use Livewire\Component;
use Innoboxrr\LaravelBlog\Models\BlogSubscriber;

class SubscribeComponent extends Component
{
    public $email;

    public function subscribe()
    {
        $this->validate(['email' => 'required|email']);
        Subscriber::create(['email' => $this->email]);

        session()->flash('message', '¡Gracias por suscribirte!');
        $this->reset('email');
    }

    public function render()
    {
        return view('themes.default.components.subscribe-component');
    }
}
