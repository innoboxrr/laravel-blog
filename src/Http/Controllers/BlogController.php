<?php

namespace Innoboxrr\LaravelBlog\Http\Controllers;

use Illuminate\Support\Facades\File;
use Innoboxrr\LaravelBlog\Http\Requests\Blog\{
    PoliciesRequest,
    PolicyRequest,
    IndexRequest,
    ShowRequest,
    CreateRequest,
    UpdateRequest,
    DeleteRequest,
    RestoreRequest,
    ForceDeleteRequest,
    ExportRequest,
    LambdaRequest
};

class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show', 'assets']);
    }

    public function policies(PoliciesRequest $request)
    {
        return $request->handle($this);   
    }

    public function policy(PolicyRequest $request)
    {
        return $request->handle();
    }

    public function index(IndexRequest $request)
    {
        return $request->handle();   
    }

    public function show(ShowRequest $request)
    {
        return $request->handle();   
    }

    public function create(CreateRequest $request)
    {
        return $request->handle();   
    }

    public function update(UpdateRequest $request)
    {
        return $request->handle();   
    }

    public function delete(DeleteRequest $request)
    {
        return $request->handle();   
    }

    public function restore(RestoreRequest $request)
    {
        return $request->handle();   
    }

    public function forceDelete(ForceDeleteRequest $request)
    {
        return $request->handle();   
    }

    public function export(ExportRequest $request)
    {
        return $request->handle();   
    }

    public function lambda(LambdaRequest $request)
    {
        return $request->handle();   
    }

    public function assets($theme, $folder, $path)
    {
        $filePath = base_path("vendor/innoboxrr/laravel-blog/resources/views/livewire/themes/$theme/assets/$folder/$path");

        if (! file_exists($filePath)) {
            abort(404);
        }

        // Extraer la extensión en minúsculas
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        // Mapeo de extensiones a MIME types
        $mimeTypes = [
            'css'   => 'text/css',
            'js'    => 'application/javascript',
            'html'  => 'text/html',
            'htm'   => 'text/html',
            'png'   => 'image/png',
            'jpg'   => 'image/jpeg',
            'jpeg'  => 'image/jpeg',
            'gif'   => 'image/gif',
            'woff2' => 'font/woff2',
            'woff'  => 'font/woff',
            'ttf'   => 'font/ttf',
            // Agrega otros MIME types según tus necesidades
        ];

        // Obtiene el MIME type a partir de la extensión, o usa mime_content_type como fallback
        $mime = $mimeTypes[$extension] ?? mime_content_type($filePath);

        return response()->file($filePath, [
            'Content-Type' => $mime
        ]);
    }

}