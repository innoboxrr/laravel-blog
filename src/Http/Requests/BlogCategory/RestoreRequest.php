<?php

namespace Innoboxrr\LaravelBlog\Http\Requests\BlogCategory;

use Innoboxrr\LaravelBlog\Models\BlogCategory;
use Innoboxrr\LaravelBlog\Http\Resources\Models\BlogCategoryResource;
use Innoboxrr\LaravelBlog\Http\Events\BlogCategory\Events\RestoreEvent;
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
        
        $blogCategory = BlogCategory::withTrashed()->findOrFail($this->blog_category_id);
        
        return $this->user()->can('restore', $blogCategory);

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

        $blogCategory->restoreModel();

        $response = new BlogCategoryResource($blogCategory);

        event(new RestoreEvent($blogCategory, $this->all(), $response));

        return $response;

    }
    
}
