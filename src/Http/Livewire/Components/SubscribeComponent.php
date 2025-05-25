<?php

namespace Innoboxrr\LaravelBlog\Http\Livewire\Components;

use Innoboxrr\LaravelBlog\Http\Livewire\BaseLivewireComponent as Component;
use Innoboxrr\LaravelBlog\Models\BlogSubscriber;
use Livewire\Attributes\On;
use Innoboxrr\LaravelBlog\Events\BlogUserSubscribe;
use Illuminate\Support\Str;
use Innoboxrr\LaravelBlog\Enums\BlogSubscriberStatus;

class SubscribeComponent extends Component
{
    public $email = '';
    public $name = '';
    public $phone = '';
    public $country_code = '';
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
            $rules['country_code'] = 'required|string';
        }

        $this->validate($rules);

        $subscriber = BlogSubscriber::create([
            'status' => BlogSubscriberStatus::PENDING->value,
            'email' => $this->email,
            'name' => $this->name,
            'phone' => $this->phone,
            'country_code' => $this->country_code,
            'token' => Str::random(32),
            'blog_id' => $this->blog->id,
        ]);

        $this->subscribed = true;
        $this->emailToConfirm = $this->email;

        event(new BlogUserSubscribe($subscriber));

        $this->reset(['email', 'name', 'phone', 'country_code']);
        $this->dispatchBrowserEvent('set-subscribe-cookie');
    }

    public function render()
    {
        return $this->renderComponent('subscribe-component');
    }
}
