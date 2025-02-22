<?php

namespace Innoboxrr\LaravelBlog\Services\BlogPost;

use Innoboxrr\LaravelBlog\Models\BlogPost;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Http\File;

class FeaturedImageService
{
    /**
     * Disco para almacenamiento (por ejemplo, "s3").
     *
     * @var string
     */
    protected $disk;

    /**
     * Directorio base para almacenar las imágenes.
     *
     * @var string
     */
    protected $dir;

    /**
     * Dimensiones para generar las versiones de la imagen.
     *
     * @var array
     */
    protected $dimensions;

    /**
     * Constructor.
     *
     * Se leen las configuraciones para el disco, el directorio y las dimensiones.
     */
    public function __construct()
    {
        $this->disk = config('laravel-blog.file_disk', 's3');
        // Directorio base, por ejemplo "public/blogs"
        $this->dir = config('laravel-blog.file_directory', 'public/blogs');
        $this->dimensions = config('laravel-blog.image_crop', [
            'original'  => ['width' => 1200, 'height' => 800],
            'thumbnail' => ['width' => 300,  'height' => 200],
            'medium'    => ['width' => 600,  'height' => 400],
            'large'     => ['width' => 1024, 'height' => 768],
        ]);
    }

    /**
     * Método estático para procesar y subir una imagen recibida (por ejemplo, desde un Request).
     *
     * @param mixed      $file       Archivo subido (por ejemplo, instancia de UploadedFile)
     * @param BlogPost   $blogPost     Instancia del BlogPost para definir la ruta de almacenamiento.
     * @return FeaturedImageService
     */
    public static function uploadImage($file, BlogPost $blogPost)
    {
        if(!$file) {
            return;
        }
        $instance = new self();
        $urls = $instance->processFlow($file, $blogPost->id);
        $instance->saveUrls($blogPost, $urls);
        return $instance;
    }

    /**
     * Método estático para generar una imagen (por ejemplo, mediante IA), procesarla y subirla.
     *
     * @param array      $params     Parámetros para la generación (por ejemplo, prompt, estilo, etc.)
     * @param BlogPost   $blogPost   Instancia del BlogPost para definir la ruta de almacenamiento.
     * @return FeaturedImageService
     */
    public static function generateImage(BlogPost $blogPost)
    {
        $instance = new self();
        // Aquí se invoca la generación de la imagen (este método debe extenderse con la lógica de IA).
        $file = $instance->generateImageViaAI($blogPost);
        $urls = $instance->processFlow($file, $blogPost->id);
        $instance->saveUrls($blogPost, $urls);
        return $instance;
    }

    /**
     * Guarda las URLs de las versiones de la imagen en el modelo BlogPost.
     * 
     */
    public function saveUrls(BlogPost $blogPost, $urls)
    {
        $blogPost->updateModelMetas([
            'original_image' => $urls['original'] ?? $blogPost->getPayload('images.original'),
            'thumbnail_image' => $urls['thumbnail'] ?? $blogPost->getPayload('images.thumbnail'),
            'medium_image' => $urls['medium'] ?? $blogPost->getPayload('images.medium'),
            'large_image' => $urls['large'] ?? $blogPost->getPayload('images.large'),
        ]);
    }

    /**
     * Flujo común para procesar la imagen: guardar en local (temporal), crear versiones, subir a S3 y eliminar localmente.
     *
     * @param mixed        $file       Archivo de entrada (UploadedFile, File, etc.)
     * @param int|string   $blogPostId ID del BlogPost para construir la ruta.
     * @return array                   Array con clave => URL de cada versión.
     *
     * @throws \Exception
     */
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

    /**
     * Guarda el archivo recibido en un directorio temporal y retorna la ruta.
     *
     * @param mixed $file Archivo (UploadedFile o File)
     * @return string     Ruta del archivo temporal.
     */
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

    /**
     * Crea y guarda en local (temporal) las versiones recortadas de la imagen según las dimensiones definidas.
     *
     * @param string $sourcePath Ruta del archivo fuente (original) en local.
     * @return array             Array asociativo con clave => ruta del archivo local.
     */
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

    /**
     * Método "stub" para generar una imagen mediante IA.
     *
     * Aquí debes integrar la lógica de generación con IA.
     * Por el momento, este método simula la generación devolviendo un archivo local.
     *
     * @param array $params Parámetros para la generación de imagen.
     * @return \Illuminate\Http\File
     *
     * @throws \Exception
     */
    protected function generateImageViaAI(BlogPost $blogPost)
    {
        $dummyPath = storage_path('app/dummy/ai_generated.jpg');
        if (!file_exists($dummyPath)) {
            throw new \Exception("No se encontró la imagen dummy para IA.");
        }
        return new File($dummyPath);
    }

    /**
     * Obtiene la extensión de un archivo.
     *
     * @param mixed $file Puede ser una instancia de UploadedFile, File o una ruta (string).
     * @return string
     */
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
