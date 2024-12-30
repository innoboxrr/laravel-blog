<?php

namespace Innoboxrr\LaravelBlog\Http\Requests\Blog;

use Innoboxrr\LaravelBlog\Models\Blog;
use Innoboxrr\LaravelBlog\Http\Resources\Models\BlogResource;
use Innoboxrr\LaravelBlog\Http\Events\Blog\Events\CreateEvent;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Innoboxrr\LaravelBlog\Support\DTOs\BlogDto;

class CreateRequest extends FormRequest
{
    protected $bloggable;

    protected BlogDto $blogDto;

    protected function prepareForValidation()
    {
        if(!$this->bloggable_type || !$this->bloggable_id) {
            return abort(403);
        }

        $this->bloggable = $this->bloggable_type::findOrFail($this->bloggable_id);
    }

    public function authorize()
    {
        if(method_exists($this->bloggable, 'canCreateBlog')) {
            return $this->bloggable->canCreateBlog($this);
        }
        return config('laravel-blog.bloggable.create');
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'slug' => 'required|string|unique:blogs,slug|regex:/^[a-z0-9-]+$/',
            'domain' => 'required|string|unique:blogs,domain|regex:/^[a-z0-9-]+$/',
            'bloggable_type' => 'required|string',
            'bloggable_id' => 'required|integer',
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
        $this->blogDto = BlogDto::fromArray($this->all());
    }

    public function handle()
    {
        $blog = $this->bloggable->createBlog($this->blogDto);
        $response = new BlogResource($blog);
        event(new CreateEvent($blog, $this->all(), $response));
        return $response;
    }
    
}
