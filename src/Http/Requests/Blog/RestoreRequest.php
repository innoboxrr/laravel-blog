<?php

namespace Innoboxrr\LaravelBlog\Http\Requests\Blog;

use Innoboxrr\LaravelBlog\Models\Blog;
use Innoboxrr\LaravelBlog\Http\Resources\Models\BlogResource;
use Innoboxrr\LaravelBlog\Http\Events\Blog\Events\RestoreEvent;
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
        
        $blog = Blog::withTrashed()->findOrFail($this->blog_id);
        
        return $this->user()->can('restore', $blog);

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

        $blog->restoreModel();

        $response = new BlogResource($blog);

        event(new RestoreEvent($blog, $this->all(), $response));

        return $response;

    }
    
}
