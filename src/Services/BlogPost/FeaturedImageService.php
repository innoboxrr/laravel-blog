<?php

namespace Innoboxrr\LaravelBlog\Services\BlogPost;

use Innoboxrr\LaravelBlog\Models\BlogPost;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Http\File;

class FeaturedImageService
{
    protected $disk;
    protected $dir;
    protected $dimensions;

    public function __construct()
    {
        $this->disk = config('laravel-blog.file_disk', 's3');
        $this->dir = config('laravel-blog.file_directory', 'public/blogs');
        $this->dimensions = config('laravel-blog.image_crop', [
            'original'  => ['width' => 1200, 'height' => 800],
            'thumbnail' => ['width' => 300,  'height' => 200],
            'medium'    => ['width' => 600,  'height' => 400],
            'large'     => ['width' => 1024, 'height' => 768],
        ]);
    }

    public static function processImage(BlogPost $blogPost)
    {
        $instance = new self();
        $originalPath = $blogPost->getPayload('images.original');

        if (!$originalPath) {
            throw new \Exception("No se encontró la imagen original para el post ID {$blogPost->id}.");
        }

        // Recuperar el contenido binario desde el disco
        $fileContent = Storage::disk($instance->disk)->get($originalPath);
        if (!$fileContent) {
            throw new \Exception("No se pudo recuperar la imagen original desde el disco.");
        }

        $urls = $instance->processFlow($fileContent, $blogPost->id);
        $instance->saveUrls($blogPost, $urls);

        if (Storage::disk($instance->disk)->exists($originalPath)) {
            Storage::disk($instance->disk)->delete($originalPath);
        }

        return $instance;
    }

    public static function generateImage(BlogPost $blogPost)
    {
        $instance = new self();
        $file = $instance->generateImageViaAI($blogPost);
        $urls = $instance->processFlow($file, $blogPost->id);
        $instance->saveUrls($blogPost, $urls);

        return $instance;
    }

    public function saveUrls(BlogPost $blogPost, $urls)
    {
        $blogPost->updateModelMetas([
            'original_image'   => $urls['original'] ?? $blogPost->getPayload('images.original'),
            'thumbnail_image'  => $urls['thumbnail'] ?? $blogPost->getPayload('images.thumbnail'),
            'medium_image'     => $urls['medium'] ?? $blogPost->getPayload('images.medium'),
            'large_image'      => $urls['large'] ?? $blogPost->getPayload('images.large'),
        ]);
    }

    protected function processFlow($file, $blogPostId)
    {
        $tempPath = $this->saveToTemporary($file);
        if (!$tempPath) {
            throw new \Exception("No se pudo guardar la imagen temporalmente.");
        }

        $localVersions = $this->createAndSaveCroppedVersions($tempPath);

        $urls = [];
        foreach ($localVersions as $key => $localFilePath) {
            $filename = basename($localFilePath);
            $s3Path = "{$this->dir}/{$blogPostId}/featured/{$filename}";

            $fileContents = file_get_contents($localFilePath);
            $result = Storage::disk($this->disk)->put($s3Path, $fileContents);

            if (!$result) {
                throw new \Exception("No se pudo subir la imagen para la dimensión {$key}.");
            }

            $urls[$key] = Storage::disk($this->disk)->url($s3Path);
        }

        foreach ($localVersions as $localFilePath) {
            if (file_exists($localFilePath)) {
                unlink($localFilePath);
            }
        }

        if (file_exists($tempPath)) {
            unlink($tempPath);
        }

        return $urls;
    }

    protected function saveToTemporary($file)
    {
        $tempDir = storage_path('app/temp');
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        $filename = Str::uuid()->toString() . '.jpg';
        $tempPath = $tempDir . '/' . $filename;

        // Si es instancia de File o tiene método getRealPath, se copia desde archivo
        if ($file instanceof File || (is_object($file) && method_exists($file, 'getRealPath'))) {
            copy($file->getRealPath(), $tempPath);
        } elseif (is_string($file)) {
            // Es contenido binario
            file_put_contents($tempPath, $file);
        } else {
            throw new \Exception("Tipo de archivo no soportado para guardar temporalmente.");
        }

        return $tempPath;
    }

    protected function createAndSaveCroppedVersions($sourcePath)
    {
        $versions = [];
        $tempDir = storage_path('app/temp');

        foreach ($this->dimensions as $key => $size) {
            $filename = Str::uuid()->toString() . '-' . $key . '.' . $this->getExtension($sourcePath);
            $destinationPath = $tempDir . '/' . $filename;

            $img = Image::read($sourcePath);

            if ($key !== 'original') {
                $img = $img->cover($size['width'], $size['height'], 'center');
            }

            $img->save($destinationPath);
            $versions[$key] = $destinationPath;
        }

        return $versions;
    }

    protected function generateImageViaAI(BlogPost $blogPost)
    {
        // Simulación: reemplaza esto por integración con servicio real de generación
        $dummyPath = storage_path('app/dummy/ai_generated.jpg');

        if (!file_exists($dummyPath)) {
            throw new \Exception("No se encontró la imagen dummy para IA.");
        }

        return new File($dummyPath);
    }

    protected function getExtension($file)
    {
        if (is_string($file)) {
            return 'jpg'; // asumimos jpg para contenido binario
        } elseif (is_string($file) && file_exists($file)) {
            return pathinfo($file, PATHINFO_EXTENSION);
        } elseif ($file instanceof File) {
            return $file->getExtension();
        }

        return 'jpg';
    }
}
