<?php

namespace Innoboxrr\LaravelBlog\Support\DTOs;

class BlogDto
{
    public int $id;
    public string $name;
    public string $slug;
    public string $status;
    public ?string $domain;
    public ?string $domain_verified_at;
    public string $bloggable_type;
    public int $bloggable_id;

    public function __construct(array $attributes = [])
    {
        $this->id = $attributes['id'] ?? 0;
        $this->name = $attributes['name'] ?? '';
        $this->slug = $attributes['slug'] ?? '';
        $this->status = $attributes['status'] ?? 'active';
        $this->domain = $attributes['domain'] ?? null;
        $this->domain_verified_at = $attributes['domain_verified_at'] ?? null;
        $this->bloggable_type = $attributes['bloggable_type'] ?? '';
        $this->bloggable_id = $attributes['bloggable_id'] ?? 0;
    }

    /**
     * Convert the DTO to an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'status' => $this->status,
            'domain' => $this->domain,
            'domain_verified_at' => $this->domain_verified_at,
            'bloggable_type' => $this->bloggable_type,
            'bloggable_id' => $this->bloggable_id,
        ];
    }

    /**
     * Create a new instance from an array of attributes.
     *
     * @param array $attributes
     * @return self
     */
    public static function fromArray(array $attributes): self
    {
        return new self($attributes);
    }
}
