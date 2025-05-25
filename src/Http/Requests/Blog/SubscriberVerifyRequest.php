<?php

namespace Innoboxrr\LaravelBlog\Http\Requests\Blog;

use Illuminate\Foundation\Http\FormRequest;
use Innoboxrr\LaravelBlog\Models\BlogSubscriber;
use Innoboxrr\LaravelBlog\Enums\BlogSubscriberStatus;
use Innoboxrr\LaravelBlog\Events\BlogUserSubscribe;
use Illuminate\Support\Str;

class SubscriberVerifyRequest extends FormRequest
{
    protected $subscriber;

    protected function prepareForValidation()
    {
        // Este método podría usarse si necesitas limpiar o transformar inputs
    }

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [];
    }

    public function messages()
    {
        return [];
    }

    public function attributes()
    {
        return [];
    }

    protected function passedValidation()
    {
        $subscriberId = $this->route('subscriber');
        $token = $this->query('token');

        $this->subscriber = BlogSubscriber::where('id', $subscriberId)
            ->where('token', $token)
            ->firstOrFail();

        $this->subscriber->status = BlogSubscriberStatus::VERIFIED->value;
        $this->subscriber->verified_at = now();
        $this->subscriber->token = Str::random(32);
        $this->subscriber->save();

        event(new BlogUserSubscribe($this->subscriber));
    }

    public function handle()
    {
        $blog = $this->subscriber->blog;

        return redirect()
            ->to(blog_route('index', ['blog' => $blog->id]))
            ->with('success', '¡Tu correo ha sido verificado correctamente! 🎉');
    }
}
