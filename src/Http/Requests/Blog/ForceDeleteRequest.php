<?php

namespace Innoboxrr\LaravelBlog\Http\Requests\Blog;

use Innoboxrr\LaravelBlog\Models\Blog;
use Innoboxrr\LaravelBlog\Http\Resources\Models\BlogResource;
use Innoboxrr\LaravelBlog\Http\Events\Blog\Events\ForceDeleteEvent;
use Illuminate\Foundation\Http\FormRequest;

class ForceDeleteRequest extends FormRequest
{

    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {

        $blog = Blog::withTrashed()->findOrFail($this->blog_id);
        
        return $this->user()->can('forceDelete', $blog);

    }

    public function rules()
    {
        return [
            'blog_id' => 'required|numeric'
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

        $blog = Blog::withTrashed()->findOrFail($this->blog_id);

        $blog->forceDeleteModel();

        $response = new BlogResource($blog);

        event(new ForceDeleteEvent($blog, $this->all(), $response));

        return $response;

    }
    
}
