<?php

namespace Innoboxrr\LaravelBlog\Http\Requests\BlogSubscriber;

use Innoboxrr\LaravelBlog\Models\BlogSubscriber;
use Innoboxrr\LaravelBlog\Http\Resources\Models\BlogSubscriberResource;
use Innoboxrr\LaravelBlog\Http\Events\BlogSubscriber\Events\CreateEvent;
use Innoboxrr\LaravelBlog\Events\BlogUserSubscribe;
use Illuminate\Foundation\Http\FormRequest;
use Innoboxrr\LaravelBlog\Enums\BlogSubscriberStatus;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CreateRequest extends FormRequest
{

    protected function prepareForValidation()
    {
        $this->merge([
            'token' => Str::random(32),
            'status' => BlogSubscriberStatus::PENDING->value,
        ]);
    }

    public function authorize()
    {
        return $this->user()->can('create', BlogSubscriber::class);
    }

    public function rules()
    {
        return [
            //
        ];
    }

    public function messages()
    {
        return [
            //
        ];
    }

    public function attributes()
    {
        return [
            //
        ];
    }

    protected function passedValidation()
    {
        //
    }

    public function handle()
    {

        $blogSubscriber = (new BlogSubscriber)->createModel($this);

        $response = new BlogSubscriberResource($blogSubscriber);

        event(new BlogUserSubscribe($blogSubscriber));
        event(new CreateEvent($blogSubscriber, $this->all(), $response));

        // Si requiere JSON retornar el recurso si no  una vista
        if ($this->wantsJson()) {
            return $response;
        }

        return redirect()
            ->to(blog_route('index', ['blog' => $blogSubscriber->blog_id, 'subscribed' => 'pending']))
            ->with('success', __('The :model was created successfully.', ['model' => __('Blog Subscriber')]));

    }
    
}
