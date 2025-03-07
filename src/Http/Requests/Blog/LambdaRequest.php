<?php

namespace Innoboxrr\LaravelBlog\Http\Requests\Blog;

use Innoboxrr\LaravelBlog\Models\Blog;
use Innoboxrr\LaravelBlog\Http\Resources\Models\BlogResource;
use Innoboxrr\LaravelBlog\Http\Events\Blog\Events\UpdateEvent;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Innoboxrr\LaravelBlog\Services\Lambda\LambdaService;

class LambdaRequest extends FormRequest
{
    protected ?Blog $blog; 

    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {
        $this->blog = Blog::find($this->blog_id);
        if($this->blog) {
            return $this->user()->can('update', $this->blog);
        } else {
            // PENDIENTE - Validar si el usuario tiene permisos para realizar la acción
            // Esto es para usar esta herramienta como tools
            return true;
        }
    }

    public function rules()
    {
        return [
            'action' => 'required|string',
            'payload' => 'sometimes|array',
            'blog_id' => 'nullable'
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
        $response = LambdaService::handle($this->all());
        return $response;
    }

}
