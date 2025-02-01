<?php

namespace Innoboxrr\LaravelBlog\Models\Traits\Operations;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

trait BlogPostOperations
{

    public function buildPayload()
    {
        return [
            'stats' => [
                'views' => $this->meta('views'),
                'likes' => $this->meta('likes'),
                'comments' => $this->meta('comments'),
            ],
            'metas' => [
                'description' => $this->meta('description'),
                'keywords' => $this->meta('keywords'),
            ],
            'images' => [
                'original' => $this->meta('original_image'),
                'thumbnail' => $this->meta('thumbnail_image'),
                'medium' => $this->meta('medium_image'),
                'large' => $this->meta('large_image'),
            ],
            'share_buttons' => [
                'facebook' => (int) $this->meta('share_on_facebook'),
                'twitter' => (int) $this->meta('share_on_twitter'),
                'linkedin' => (int) $this->meta('share_on_linkedin'),
                // ..
            ],
            // Configurar
        ];
    }

    public function updatePayload()
    {
        $this->payload = $this->buildPayload();
        return $this->save();
    }

    public function setFeaturedImage($request)
    {
        // Verificar que se haya enviado el archivo 'featured_image'
        if (!$request->hasFile('featured_image')) {
            return false;
        }

        $file = $request->file('featured_image');
        $extension = $file->getClientOriginalExtension();
        $baseName  = 'featured_' . time();
        // Definimos una ruta base; el prefijo "public/" es una convención para identificar la ruta pública
        $basePath  = 'public/blogs/' . $this->id;

        // Instanciar la imagen original con Intervention Image
        $image = Image::make($file);

        // Obtener las dimensiones definidas en la configuración
        $dimensions = config('laravel-blog.image_crop');

        $paths = [];

        foreach ($dimensions as $size => $dimension) {
            // Clonar la imagen para no modificar la original
            $resizedImage = clone $image;
            // Redimensionar y recortar la imagen según las dimensiones definidas
            $resizedImage->fit($dimension['width'], $dimension['height']);

            // Definir nombre de archivo y ruta
            $fileName = "{$baseName}_{$size}.{$extension}";
            $filePath = $basePath . '/' . $fileName;

            // Guardar la imagen redimensionada en S3 con visibilidad pública
            Storage::disk('s3')->put(
                $filePath,
                (string) $resizedImage->encode(),
                'public' // Establece la visibilidad a pública
            );

            $paths[$size] = $filePath;
        }

        // Actualizar las metas con los paths de las imágenes generadas
        $this->setMeta('original_image', $paths['original'])
             ->setMeta('thumbnail_image', $paths['thumbnail'])
             ->setMeta('medium_image', $paths['medium'])
             ->setMeta('large_image', $paths['large']);

        // Actualizar el payload del post y guardar el modelo
        return $this->updatePayload();
    }
}