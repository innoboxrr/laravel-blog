<?php

namespace Innoboxrr\LaravelBlog\Http\Requests\BlogSubscriber;

use Innoboxrr\LaravelBlog\Models\BlogSubscriber;
use Innoboxrr\LaravelBlog\Http\Resources\Models\BlogSubscriberResource;
use Innoboxrr\LaravelBlog\Http\Events\BlogSubscriber\Events\DeleteEvent;
use Illuminate\Foundation\Http\FormRequest;

class DeleteRequest extends FormRequest
{

    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {
        
        $blogSubscriber = BlogSubscriber::findOrFail($this->blog_subscriber_id);

        return $this->user()->can('delete', $blogSubscriber);

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

        $blogSubscriber = BlogSubscriber::findOrFail($this->blog_subscriber_id);

        $blogSubscriber->deleteModel();

        $response = new BlogSubscriberResource($blogSubscriber);

        event(new DeleteEvent($blogSubscriber, $this->all(), $response));

        return $response;

    }
    
}
