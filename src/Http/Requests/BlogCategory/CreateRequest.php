<?php

namespace Innoboxrr\LaravelBlog\Http\Requests\BlogCategory;

use Innoboxrr\LaravelBlog\Models\BlogCategory;
use Innoboxrr\LaravelBlog\Http\Resources\Models\BlogCategoryResource;
use Innoboxrr\LaravelBlog\Http\Events\BlogCategory\Events\CreateEvent;
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

        return $this->user()->can('create', BlogCategory::class);

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

        $blogCategory = (new BlogCategory)->createModel($this);

        $response = new BlogCategoryResource($blogCategory);

        event(new CreateEvent($blogCategory, $this->all(), $response));

        return $response;

    }
    
}
