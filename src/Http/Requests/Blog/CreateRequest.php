<?php

namespace Innoboxrr\LaravelBlog\Http\Requests\Blog;

use Innoboxrr\LaravelBlog\Models\Blog;
use Innoboxrr\LaravelBlog\Http\Resources\Models\BlogResource;
use Innoboxrr\LaravelBlog\Http\Events\Blog\Events\CreateEvent;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateRequest extends FormRequest
{

    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {

        return $this->user()->can('create', Blog::class);

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

        $blog = (new Blog)->createModel($this);

        $response = new BlogResource($blog);

        event(new CreateEvent($blog, $this->all(), $response));

        return $response;

    }
    
}
