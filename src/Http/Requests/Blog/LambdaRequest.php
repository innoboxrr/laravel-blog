<?php

namespace Innoboxrr\LaravelBlog\Http\Requests\Blog;

use Innoboxrr\LaravelBlog\Models\Blog;
use Innoboxrr\LaravelBlog\Http\Resources\Models\BlogResource;
use Innoboxrr\LaravelBlog\Http\Events\Blog\Events\UpdateEvent;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Innoboxrr\LaravelBlog\Services\Lambda\LambdaService;

class LambdaRequest extends FormRequest
{
    protected Blog $blog;

    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {
        $this->blog = Blog::findOrFail($this->blog_id);
        return $this->user()->can('update', $this->blog);
    }

    public function rules()
    {
        return [
            'action' => 'required|string',
            'payload' => 'sometimes|array',
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
        $response = LambdaService::handle($this->all());
        return $response;
    }

}
