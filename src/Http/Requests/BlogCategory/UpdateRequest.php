<?php

namespace Innoboxrr\LaravelBlog\Http\Requests\BlogCategory;

use Innoboxrr\LaravelBlog\Models\BlogCategory;
use Innoboxrr\LaravelBlog\Http\Resources\Models\BlogCategoryResource;
use Innoboxrr\LaravelBlog\Http\Events\BlogCategory\Events\UpdateEvent;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{

    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {
        
        $blogCategory = BlogCategory::findOrFail($this->blog_category_id);

        return $this->user()->can('update', $blogCategory);

    }

    public function rules()
    {
        return [
            //
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

        $blogCategory = BlogCategory::findOrFail($this->blog_category_id);

        $blogCategory = $blogCategory->updateModel($this);

        $response = new BlogCategoryResource($blogCategory);

        event(new UpdateEvent($blogCategory, $this->all(), $response));

        return $response;

    }

}
