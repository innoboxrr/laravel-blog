<?php

namespace Innoboxrr\LaravelBlog\Services\BlogPost;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class AssetService
{
    protected string $baseAssetPath;

    public function __construct()
    {
        $this->baseAssetPath = base_path('vendor/innoboxrr/laravel-blog/resources/views/livewire/themes');
    }

    private function getAssetPath(string $theme, string $folder, string $path): string
    {
        $fullPath = realpath("{$this->baseAssetPath}/{$theme}/assets/{$folder}/{$path}");
        if (file_exists($fullPath)) {
            return $fullPath;
        }
        abort(404);
    }

    private function getMimeType(string $filePath): string
    {
        return Cache::remember("mime-type:{$filePath}", now()->addDay(), function () use ($filePath) {
            $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
            $mimeTypes = config('laravel-blog.assets_mime_types');
            return $mimeTypes[$extension] ?? File::mimeType($filePath);
        });
    }

    private function serveAsset(string $filePath)
    {
        // If a CDN is enabled, redirect to the CDN URL
        if (config('laravel-blog.assets_cdn_enabled')) {
            return redirect(config('laravel-blog.assets_cdn_url') . '/' . basename($filePath));
        }
        // Otherwise, serve the file directly
        return response()->file($filePath, [
            'Content-Type' => $this->getMimeType($filePath),
        ]);
    }

    public function getAsset(string $theme, string $folder, string $path)
    {
        $filePath = $this->getAssetPath($theme, $folder, $path);
        return $this->serveAsset($filePath);
    }
}
