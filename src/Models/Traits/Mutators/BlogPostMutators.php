<?php

namespace Innoboxrr\LaravelBlog\Models\Traits\Mutators;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

trait BlogPostMutators
{
    /**
     * Normaliza un valor de imagen: siempre regresa un string URL absoluto.
     */
    protected function normalizeImage(string $payloadKey, string $fallback): string
    {
        // Obtén el valor crudo del payload
        $value = $this->getPayload($payloadKey, $fallback);

        // Si viene array/objeto o null, usa fallback
        if (!is_string($value)) {
            $value = $fallback;
        } else {
            $value = trim($value);
            if ($value === '') {
                $value = $fallback;
            }
        }

        // Si ya es URL absoluta http/https, úsala tal cual
        if (Str::startsWith($value, ['http://', 'https://'])) {
            return $value;
        }

        // Asegura una URL absoluta a partir de un path relativo
        // (URL::to siempre devuelve string; nunca un UrlGenerator)
        return URL::to($value);
    }

    public function getOriginalImageAttribute(): string
    {
        return $this->normalizeImage(
            'images.original',
            'https://picsum.photos/seed/' . $this->id . '/800/600'
        );
    }

    public function getThumbnailImageAttribute(): string
    {
        return $this->normalizeImage(
            'images.thumbnail',
            'https://picsum.photos/seed/' . $this->id . '/300/200'
        );
    }

    public function getLargeImageAttribute(): string
    {
        return $this->normalizeImage(
            'images.large',
            'https://picsum.photos/seed/' . $this->id . '/1024/768'
        );
    }

    public function getMediumImageAttribute(): string
    {
        return $this->normalizeImage(
            'images.medium',
            'https://picsum.photos/seed/' . $this->id . '/600/400'
        );
    }

    public function getPlaylistAttribute(): array
    {
        $raw = $this->getPayload('playlist', []);
        if (is_array($raw)) {
            return $raw;
        }

        if (is_string($raw) && $raw !== '') {
            $decoded = json_decode($raw, true);
            return is_array($decoded) ? $decoded : [];
        }

        return [];
    }

    public function getCommentsCountAttribute(): int
    {
        return (int) ($this->getPayload('stats.comments') ?? 0);
    }
}
