<?php

namespace Innoboxrr\LaravelBlog\Http\Requests\BlogSubscriber;

use Innoboxrr\LaravelBlog\Models\BlogSubscriber;
use Innoboxrr\LaravelBlog\Http\Resources\Models\BlogSubscriberResource;
use Innoboxrr\LaravelBlog\Http\Events\BlogSubscriber\Events\RestoreEvent;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RestoreRequest extends FormRequest
{

    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {
        
        $blogSubscriber = BlogSubscriber::withTrashed()->findOrFail($this->blog_subscriber_id);
        
        return $this->user()->can('restore', $blogSubscriber);

    }

    public function rules()
    {
        return [
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

        $blogSubscriber = BlogSubscriber::withTrashed()->findOrFail($this->blog_subscriber_id);

        $blogSubscriber->restoreModel();

        $response = new BlogSubscriberResource($blogSubscriber);

        event(new RestoreEvent($blogSubscriber, $this->all(), $response));

        return $response;

    }
    
}
