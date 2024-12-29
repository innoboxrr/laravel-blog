<?php

namespace Innoboxrr\LaravelBlog\Http\Requests\BlogPost;

use Innoboxrr\LaravelBlog\Models\BlogPost;
use Innoboxrr\LaravelBlog\Http\Resources\Models\BlogPostResource;
use Innoboxrr\LaravelBlog\Http\Events\BlogPost\Events\ForceDeleteEvent;
use Illuminate\Foundation\Http\FormRequest;

class ForceDeleteRequest extends FormRequest
{

    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {

        $blogPost = BlogPost::withTrashed()->findOrFail($this->blog_post_id);
        
        return $this->user()->can('forceDelete', $blogPost);

    }

    public function rules()
    {
        return [
            'blog_post_id' => 'required|numeric'
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

        $blogPost = BlogPost::withTrashed()->findOrFail($this->blog_post_id);

        $blogPost->forceDeleteModel();

        $response = new BlogPostResource($blogPost);

        event(new ForceDeleteEvent($blogPost, $this->all(), $response));

        return $response;

    }
    
}
