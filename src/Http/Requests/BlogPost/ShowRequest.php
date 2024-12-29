<?php

namespace Innoboxrr\LaravelBlog\Http\Requests\BlogPost;

use Innoboxrr\LaravelBlog\Models\BlogPost;
use Innoboxrr\LaravelBlog\Http\Resources\Models\BlogPostResource;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShowRequest extends FormRequest
{

    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {

        $blogPost = BlogPost::findOrFail($this->blog_post_id);

        return $this->user()->can('view', $blogPost);

    }

    public function rules()
    {
        return [
            'load_relations' => [
                'nullable',
                'array',
                Rule::in(BlogPost::$loadable_relations)
            ],
            'load_counts' => [
                'nullable',
                'array',
                Rule::in(BlogPost::$loadable_counts)
            ],
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

        $blogPost = BlogPost::where('id', $this->blog_post_id)
            ->with($this->load_relations ?? [])
            ->withCount($this->load_counts ?? [])
            ->firstOrFail();

        return new BlogPostResource($blogPost);

    }
    
}
