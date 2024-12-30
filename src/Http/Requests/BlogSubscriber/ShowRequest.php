<?php

namespace Innoboxrr\LaravelBlog\Http\Requests\BlogSubscriber;

use Innoboxrr\LaravelBlog\Models\BlogSubscriber;
use Innoboxrr\LaravelBlog\Http\Resources\Models\BlogSubscriberResource;
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

        $blogSubscriber = BlogSubscriber::findOrFail($this->blog_subscriber_id);

        return $this->user()->can('view', $blogSubscriber);

    }

    public function rules()
    {
        return [
            'load_relations' => [
                'nullable',
                'array',
                Rule::in(BlogSubscriber::$loadable_relations)
            ],
            'load_counts' => [
                'nullable',
                'array',
                Rule::in(BlogSubscriber::$loadable_counts)
            ],
            'blog_subscriber_id' => 'required|numeric'
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

        $blogSubscriber = BlogSubscriber::where('id', $this->blog_subscriber_id)
            ->with($this->load_relations ?? [])
            ->withCount($this->load_counts ?? [])
            ->firstOrFail();

        return new BlogSubscriberResource($blogSubscriber);

    }
    
}
