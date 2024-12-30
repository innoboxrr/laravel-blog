<?php

namespace Innoboxrr\LaravelBlog\Http\Requests\BlogSubscriber;

use Innoboxrr\LaravelBlog\Models\BlogSubscriber;
use Innoboxrr\LaravelBlog\Http\Resources\Models\BlogSubscriberResource;
use Innoboxrr\LaravelBlog\Http\Events\BlogSubscriber\Events\UpdateEvent;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{

    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {
        
        $blogSubscriber = BlogSubscriber::findOrFail($this->blog_subscriber_id);

        return $this->user()->can('update', $blogSubscriber);

    }

    public function rules()
    {
        return [
            //
            'blog_subscriber_id' => 'required|numeric'
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

        $blogSubscriber = BlogSubscriber::findOrFail($this->blog_subscriber_id);

        $blogSubscriber = $blogSubscriber->updateModel($this);

        $response = new BlogSubscriberResource($blogSubscriber);

        event(new UpdateEvent($blogSubscriber, $this->all(), $response));

        return $response;

    }

}
