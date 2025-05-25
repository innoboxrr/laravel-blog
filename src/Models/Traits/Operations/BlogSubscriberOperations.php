<?php

namespace Innoboxrr\LaravelBlog\Models\Traits\Operations;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Innoboxrr\LaravelBlog\Enums\BlogSubscriberStatus;

trait BlogSubscriberOperations
{

    public function buildPayload()
    {
        return [];
    }

    public function updatePayload()
    {
        $this->payload = $this->buildPayload();
        return $this->save();
    }

    public function isVerified()
    {
        return $this->status === BlogSubscriberStatus::VERIFIED->value;
    }

    public function sendVerificationEmail()
    {
        if (! $this->email || ! $this->token || ! $this->blog) {
            return false;
        }

        // Usa blog_route para que respete dominio personalizado o subruta
        $verificationUrl = blog_route(
            'subscriber.verify',
            [
                'blog' => $this->blog->id,
                'subscriber' => $this->id,
                'token' => $this->token,
            ],
            true
        );

        $theme = $this->blog->theme ?? 'default';
        $view = "laravel-blog::livewire.themes.$theme.emails.verify-subscriber";

        if (!View::exists($view)) {
            report("No se encontró la vista del correo: $view");
            return false;
        }

        $data = [
            'subscriber' => $this,
            'blog' => $this->blog,
            'verificationUrl' => $verificationUrl,
        ];

        return Mail::send($view, $data, function ($message) {
            $message->to($this->email)
                ->subject('Confirma tu suscripción al blog');
        });
    }
}