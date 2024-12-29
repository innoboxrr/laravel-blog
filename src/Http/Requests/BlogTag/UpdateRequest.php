<?php

namespace Innoboxrr\LaravelBlog\Http\Requests\BlogTag;

use Innoboxrr\LaravelBlog\Models\BlogTag;
use Innoboxrr\LaravelBlog\Http\Resources\Models\BlogTagResource;
use Innoboxrr\LaravelBlog\Http\Events\BlogTag\Events\UpdateEvent;
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
        
        $blogTag = BlogTag::findOrFail($this->blog_tag_id);

        return $this->user()->can('update', $blogTag);

    }

    public function rules()
    {
        return [
            //
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

        $blogTag = BlogTag::findOrFail($this->blog_tag_id);

        $blogTag = $blogTag->updateModel($this);

        $response = new BlogTagResource($blogTag);

        event(new UpdateEvent($blogTag, $this->all(), $response));

        return $response;

    }

}
