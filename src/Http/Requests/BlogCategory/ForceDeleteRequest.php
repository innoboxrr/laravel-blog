<?php

namespace Innoboxrr\LaravelBlog\Http\Requests\BlogCategory;

use Innoboxrr\LaravelBlog\Models\BlogCategory;
use Innoboxrr\LaravelBlog\Http\Resources\Models\BlogCategoryResource;
use Innoboxrr\LaravelBlog\Http\Events\BlogCategory\Events\ForceDeleteEvent;
use Illuminate\Foundation\Http\FormRequest;

class ForceDeleteRequest extends FormRequest
{

    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {

        $blogCategory = BlogCategory::withTrashed()->findOrFail($this->blog_category_id);
        
        return $this->user()->can('forceDelete', $blogCategory);

    }

    public function rules()
    {
        return [
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

        $blogCategory = BlogCategory::withTrashed()->findOrFail($this->blog_category_id);

        $blogCategory->forceDeleteModel();

        $response = new BlogCategoryResource($blogCategory);

        event(new ForceDeleteEvent($blogCategory, $this->all(), $response));

        return $response;

    }
    
}
