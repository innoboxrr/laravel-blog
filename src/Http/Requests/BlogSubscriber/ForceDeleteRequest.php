<?php

namespace Innoboxrr\LaravelBlog\Http\Requests\BlogSubscriber;

use Innoboxrr\LaravelBlog\Models\BlogSubscriber;
use Innoboxrr\LaravelBlog\Http\Resources\Models\BlogSubscriberResource;
use Innoboxrr\LaravelBlog\Http\Events\BlogSubscriber\Events\ForceDeleteEvent;
use Illuminate\Foundation\Http\FormRequest;

class ForceDeleteRequest extends FormRequest
{

    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {

        $blogSubscriber = BlogSubscriber::withTrashed()->findOrFail($this->blog_subscriber_id);
        
        return $this->user()->can('forceDelete', $blogSubscriber);

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

        $blogSubscriber->forceDeleteModel();

        $response = new BlogSubscriberResource($blogSubscriber);

        event(new ForceDeleteEvent($blogSubscriber, $this->all(), $response));

        return $response;

    }
    
}
