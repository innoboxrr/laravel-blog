<?php

namespace Innoboxrr\LaravelBlog\Http\Livewire;

use Innoboxrr\LaravelBlog\Http\Livewire\BaseLivewireComponent as Component;
use Innoboxrr\LaravelBlog\Events\BlogUserContact;
use Illuminate\Support\Facades\Request;

class BlogContact extends Component
{
    public $name = '';
    public $email = '';
    public $phone = '';
    public $message = '';

    public function submit()
    {
        $this->validate([
            'name' => 'required|string|min:2',
            'email' => 'required|email',
            'phone' => 'nullable|string|min:8',
            'message' => 'required|string|min:10',
        ]);

        event(new BlogUserContact([
            'blog_id' => $this->blog->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'message' => $this->message,
            'referer' => request()->header('referer'),
            'ip' => request()->ip(),
            'user_agent' => request()->header('user-agent'),
            'timestamp' => now(),
        ]));

        $this->reset(['name', 'email', 'phone', 'message']);

        $this->dispatch('swal:alert', [
            'icon' => 'success',
            'title' => 'Mensaje enviado',
            'text' => 'Gracias por contactarnos. Te responderemos pronto.',
        ]);
    }

    public function render()
    {
        return $this->renderView('contact');
    }
}
