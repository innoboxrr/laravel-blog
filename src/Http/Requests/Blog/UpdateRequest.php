<?php

namespace Innoboxrr\LaravelBlog\Http\Requests\Blog;

use Innoboxrr\LaravelBlog\Models\Blog;
use Innoboxrr\LaravelBlog\Http\Resources\Models\BlogResource;
use Innoboxrr\LaravelBlog\Http\Events\Blog\Events\UpdateEvent;
use Illuminate\Foundation\Http\FormRequest;
use Innoboxrr\Support\Http\Requests\RequestFormater;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{

    protected function prepareForValidation()
    {
        RequestFormater::format($this);
    }

    public function authorize()
    {
        
        $blog = Blog::findOrFail($this->blog_id);

        return $this->user()->can('update', $blog);

    }

    public function rules()
    {
        return [
            //
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

        $blog = Blog::findOrFail($this->blog_id);

        $blog = $blog->updateModel($this);

        $response = new BlogResource($blog);

        event(new UpdateEvent($blog, $this->all(), $response));

        return $response;

    }

}
