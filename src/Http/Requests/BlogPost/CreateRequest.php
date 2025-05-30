<?php

namespace Innoboxrr\LaravelBlog\Http\Requests\BlogPost;

use Innoboxrr\LaravelBlog\Models\BlogPost;
use Innoboxrr\LaravelBlog\Enums\BlogPostStatus;
use Innoboxrr\LaravelBlog\Http\Resources\Models\BlogPostResource;
use Innoboxrr\LaravelBlog\Http\Events\BlogPost\Events\CreateEvent;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateRequest extends FormRequest
{

    protected function prepareForValidation()
    {
        // Remover del request el campo payload
        $this->merge($this->except('payload'));

        $this->merge([
            'author_id' => $this->user()->id,
            'thumbnail_image' => $this->original_image ?? null,
            'medium_image' => $this->original_image ?? null,
            'large_image' => $this->original_image ?? null,
        ]);
    }

    public function authorize()
    {
        return $this->user()->can('create', BlogPost::class);
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|alpha_dash|unique:blog_posts,slug',
            'status' => ['required', Rule::in(BlogPostStatus::toArray())],
            'content' => 'required|string',
            'blog_id' => 'required|integer|exists:blogs,id',
            'published_at' => 'nullable|date',
            'original_image' => 'nullable|string',
            'author_id' => 'required|integer|exists:users,id',
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
        $blogPost = (new BlogPost)->createModel($this);
        $response = new BlogPostResource($blogPost);
        event(new CreateEvent($blogPost, $this->all(), $response));
        return $response;
    }
    
}
