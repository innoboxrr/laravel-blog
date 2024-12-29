<?php

namespace Innoboxrr\LaravelBlog\Http\Requests\BlogCategory;

use Innoboxrr\LaravelBlog\Models\BlogCategory;
use Innoboxrr\LaravelBlog\Http\Resources\Models\BlogCategoryResource;
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

        $blogCategory = BlogCategory::findOrFail($this->blog_category_id);

        return $this->user()->can('view', $blogCategory);

    }

    public function rules()
    {
        return [
            'load_relations' => [
                'nullable',
                'array',
                Rule::in(BlogCategory::$loadable_relations)
            ],
            'load_counts' => [
                'nullable',
                'array',
                Rule::in(BlogCategory::$loadable_counts)
            ],
            'blog_category_id' => 'required|numeric'
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

        $blogCategory = BlogCategory::where('id', $this->blog_category_id)
            ->with($this->load_relations ?? [])
            ->withCount($this->load_counts ?? [])
            ->firstOrFail();

        return new BlogCategoryResource($blogCategory);

    }
    
}
