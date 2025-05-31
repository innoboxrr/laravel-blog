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
        
        // Directorio base, por ejemplo "public/blogs"
        $this->dir = config('laravel-blog.file_directory', 'public/blogs');

        // PENDIENTE: Después hacer que el blog defina los tamaños de las imágenes
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
        // Recuperar el archivo original desde el disco.
        $file = Storage::disk($instance->disk)->get($originalPath);
        if (!$file) {
            throw new \Exception("No se pudo recuperar la imagen original desde el disco.");
        }

        // Procesar la imagen y obtener las URLs de las versiones.
        $urls = $instance->processFlow($file, $blogPost->id);

        // Guardar las URLs en el modelo del blog post.
        $instance->saveUrls($blogPost, $urls);

        // Elimianr la imagen original del disco, si es necesario.
        if (Storage::disk($instance->disk)->exists($originalPath)) {
            Storage::disk($instance->disk)->delete($originalPath);
        }

        return $instance;
    }

    public static function generateImage(BlogPost $blogPost)
    {
        $instance = new self();
        // Aquí se invoca la generación de la imagen (este método debe extenderse con la lógica de IA).
        $file = $instance->generateImageViaAI($blogPost);
        $urls = $instance->processFlow($file, $blogPost->id);
        $instance->saveUrls($blogPost, $urls);
        return $instance;
    }

    public function saveUrls(BlogPost $blogPost, $urls)
    {
        $blogPost->updateModelMetas([
            'original_image' => $urls['original'] ?? $blogPost->getPayload('images.original'),
            'thumbnail_image' => $urls['thumbnail'] ?? $blogPost->getPayload('images.thumbnail'),
            'medium_image' => $urls['medium'] ?? $blogPost->getPayload('images.medium'),
            'large_image' => $urls['large'] ?? $blogPost->getPayload('images.large'),
        ]);
    }

    protected function processFlow($file, $blogPostId)
    {
        // 1. Guardar el archivo original en un directorio temporal.
        $tempPath = $this->saveToTemporary($file);
        if (!$tempPath) {
            throw new \Exception("No se pudo guardar la imagen temporalmente.");
        }

        // 2. Crear y guardar en local (temporal) las versiones recortadas y el original.
        // Este método retorna un array asociativo: [ 'original' => '/ruta/local/imagen-original.jpg', ... ]
        $localVersions = $this->createAndSaveCroppedVersions($tempPath);

        // 3. Subir cada versión al disco configurado (por ejemplo, S3) y obtener la URL.
        $urls = [];
        foreach ($localVersions as $key => $localFilePath) {
            $filename = basename($localFilePath); // Ya se generó un nombre único en el método anterior.
            // Construir la ruta en S3: directorio base/blogPostId/featured/filename
            $s3Path = $this->dir . '/' . $blogPostId . '/featured/' . $filename;
            $fileContents = file_get_contents($localFilePath);
            $result = Storage::disk($this->disk)->put($s3Path, $fileContents);
            if (!$result) {
                throw new \Exception("No se pudo subir la imagen para la dimensión {$key}.");
            }
            $urls[$key] = Storage::disk($this->disk)->url($s3Path);
        }

        // 4. Eliminar las imágenes locales temporales (tanto el original como las versiones).
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
        // Si el archivo tiene el método hashName(), lo usamos; de lo contrario generamos un nombre único.
        if (method_exists($file, 'hashName')) {
            $filename = $file->hashName();
        } else {
            $filename = Str::uuid()->toString() . '.' . $this->getExtension($file);
        }
        $tempPath = $tempDir . '/' . $filename;
        if (method_exists($file, 'move')) {
            $file->move($tempDir, $filename);
        } else {
            copy($file->getRealPath(), $tempPath);
        }
        return $tempPath;
    }

    protected function createAndSaveCroppedVersions($sourcePath)
    {
        $versions = [];
        $tempDir = storage_path('app/temp');
        foreach ($this->dimensions as $key => $size) {
            // Generar un nombre único para cada versión.
            $filename = Str::uuid()->toString() . '-' . $key . '.' . $this->getExtension($sourcePath);
            $destinationPath = $tempDir . '/' . $filename;
            if ($key === 'original') {
                $img = Image::read($sourcePath);
            } else {
                $img = Image::read($sourcePath)
                    ->cover($size['width'], $size['height'], 'center');
            }
            // Guardar la imagen procesada en la ruta destino.
            $img->save($destinationPath);
            $versions[$key] = $destinationPath;
        }
        return $versions;
    }

    protected function generateImageViaAI(BlogPost $blogPost)
    {
        $dummyPath = storage_path('app/dummy/ai_generated.jpg');
        if (!file_exists($dummyPath)) {
            throw new \Exception("No se encontró la imagen dummy para IA.");
        }
        return new File($dummyPath);
    }

    protected function getExtension($file)
    {
        if (is_string($file)) {
            return pathinfo($file, PATHINFO_EXTENSION);
        } elseif (method_exists($file, 'getClientOriginalExtension')) {
            return $file->getClientOriginalExtension();
        } elseif (method_exists($file, 'getExtension')) {
            return $file->getExtension();
        }
        return 'jpg';
    }
}
