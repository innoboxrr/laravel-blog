<?php

namespace Innoboxrr\LaravelBlog\Http\Requests\Blog;

use Innoboxrr\LaravelBlog\Services\BlogPost\AssetService;
use Illuminate\Foundation\Http\FormRequest;

class AssetsRequest extends FormRequest
{

    protected $assetService;

    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'theme' => 'string',
            'folder' => 'string',
            'path' => 'string',
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
        $this->assetService = new AssetService();
    }

    public function handle()
    {
        return $this->assetService->getAsset($this->theme, $this->folder, $this->path);
    }

}
