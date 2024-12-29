<?php

namespace Innoboxrr\LaravelBlog\Http\Requests\BlogTag;

use Innoboxrr\LaravelBlog\Models\BlogTag;
use Innoboxrr\LaravelBlog\Http\Resources\Models\BlogTagResource;
use Innoboxrr\LaravelBlog\Http\Events\BlogTag\Events\RestoreEvent;
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
        
        $blogTag = BlogTag::withTrashed()->findOrFail($this->blog_tag_id);
        
        return $this->user()->can('restore', $blogTag);

    }

    public function rules()
    {
        return [
            'blog_tag_id' => 'required|numeric'
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

        $blogTag = BlogTag::withTrashed()->findOrFail($this->blog_tag_id);

        $blogTag->restoreModel();

        $response = new BlogTagResource($blogTag);

        event(new RestoreEvent($blogTag, $this->all(), $response));

        return $response;

    }
    
}
