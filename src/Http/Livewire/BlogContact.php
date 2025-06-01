<?php

namespace Innoboxrr\LaravelBlog\Http\Livewire;

use Innoboxrr\LaravelBlog\Http\Livewire\BaseLivewireComponent as Component;
use Innoboxrr\LaravelBlog\Events\BlogUserContact;

class BlogContact extends Component
{
    public $name = '';
    public $email = '';
    public $phone = '';
    public $phone_formatted = '';
    public $message = '';

    public function submit()
    {
        $this->validate([
            'name' => 'required|string|min:2',
            'email' => 'required|email',
            'phone' => 'nullable|string|min:8',
            'message' => 'required|string|min:10',
        ]);

        if (!empty($this->phone)) {
            $parsed = getFormattedPhone($this->phone);
            $this->phone_formatted = $parsed['formatted'] ?? $this->phone;
        }

        event(new BlogUserContact([
            'blog_id'     => $this->blog->id,
            'name'        => $this->name,
            'email'       => $this->email,
            'phone'       => $this->phone_formatted,
            'message'     => $this->message,
        ]));

        $this->reset([
            'name', 
            'email', 
            'phone', 
            'phone_formatted', 
            'message'
        ]);

        $this->dispatch('swal:alert', [
            'icon' => 'info',
            'title' => '¡Mensaje enviado!',
            'text' => 'Gracias por contactarnos. Nos pondremos en contacto contigo pronto.',
        ]);
    }

    public function render()
    {
        return $this->renderView('contact');
    }
}
