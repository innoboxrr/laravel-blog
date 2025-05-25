<?php

namespace Innoboxrr\LaravelBlog\Http\Livewire\Components;

use Innoboxrr\LaravelBlog\Http\Livewire\BaseLivewireComponent as Component;
use Livewire\Attributes\On;
use Illuminate\Support\Str;
use Innoboxrr\LaravelBlog\Models\BlogSubscriber;
use Innoboxrr\LaravelBlog\Events\BlogUserSubscribe;
use Innoboxrr\LaravelBlog\Enums\BlogSubscriberStatus;
use Illuminate\Support\Facades\Request;

class SubscribeComponent extends Component
{
    public $email = '';
    public $name = '';
    public $phone = '';
    public $phone_formatted = '';


    public $emailToConfirm = '';
    public $showModal = false;

    // Personalización externa
    public $showName = true;
    public $showPhone = true;
    public $alwaysShow = false;

    public $subscribed = false;

    public function mount()
    {
        $this->showModal = $this->alwaysShow;

        $subscribed = Request::query('subscribed');

        if ($subscribed === 'pending') {
            $this->dispatch('swal:alert', [
                'icon' => 'info',
                'title' => 'Revisa tu correo 📩',
                'text' => 'Te hemos enviado un correo de confirmación. Por favor, verifica tu bandeja de entrada.',
            ]);
        }

        if ($subscribed === 'success') {
            $this->dispatch('swal:alert', [
                'icon' => 'success',
                'title' => '¡Suscripción confirmada!',
                'text' => 'Gracias por confirmar tu suscripción.',
            ]);
        }
    }


    #[On('openSubscribeModal')]
    public function openSubscribeModal()
    {
        $this->showModal = true;
    }

    public function subscribe()
    {
        $rules = [
            'email' => 'required|email',
        ];

        if ($this->showName) {
            $rules['name'] = 'required|string|min:2';
        }

        if ($this->showPhone) {
            $rules['phone'] = 'required|string|min:8';
            $parsed = getFormattedPhone($this->phone);
            $this->phone_formatted = isset($parsed['formatted']) ? $parsed['formatted'] : '';
        }

        $this->validate($rules);

        $subscriber = BlogSubscriber::updateOrCreate([
            'email' => $this->email,
            'blog_id' => $this->blog->id,
        ],[
            'status' => BlogSubscriberStatus::PENDING->value,
            'name' => $this->name,
            'phone' => $this->phone_formatted,
            'token' => Str::random(32),
        ]);

        $this->subscribed = true;
        $this->emailToConfirm = $this->email;

        event(new BlogUserSubscribe($subscriber));

        $this->reset(['email', 'name', 'phone']);
        $this->dispatch('set-subscribe-cookie');
    }

    public function resendConfirmation()
    {
        $subscriber = BlogSubscriber::where('email', $this->emailToConfirm)
            ->where('blog_id', $this->blog->id)
            ->where('status', BlogSubscriberStatus::PENDING->value)
            ->first();

        event(new BlogUserSubscribe($subscriber));
    }

    public function render()
    {
        return $this->renderComponent('subscribe-component');
    }
}