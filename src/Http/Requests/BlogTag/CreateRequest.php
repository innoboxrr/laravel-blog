<?php

namespace Innoboxrr\LaravelBlog\Http\Requests\BlogTag;

use Innoboxrr\LaravelBlog\Models\BlogTag;
use Innoboxrr\LaravelBlog\Http\Resources\Models\BlogTagResource;
use Innoboxrr\LaravelBlog\Http\Events\BlogTag\Events\CreateEvent;
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

        return $this->user()->can('create', BlogTag::class);

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

        $blogTag = (new BlogTag)->createModel($this);

        $response = new BlogTagResource($blogTag);

        event(new CreateEvent($blogTag, $this->all(), $response));

        return $response;

    }
    
}
