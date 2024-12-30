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
    public ?array $payload;
    public string $bloggable_type;
    public int $bloggable_id;
    public string $created_at;
    public string $updated_at;
    public ?string $deleted_at;

    public function __construct(array $attributes = [])
    {
        $this->id = $attributes['id'] ?? 0;
        $this->name = $attributes['name'] ?? '';
        $this->slug = $attributes['slug'] ?? '';
        $this->status = $attributes['status'] ?? 'active';
        $this->domain = $attributes['domain'] ?? null;
        $this->domain_verified_at = $attributes['domain_verified_at'] ?? null;
        $this->payload = isset($attributes['payload']) ? json_decode($attributes['payload'], true) : null;
        $this->bloggable_type = $attributes['bloggable_type'] ?? '';
        $this->bloggable_id = $attributes['bloggable_id'] ?? 0;
        $this->created_at = $attributes['created_at'] ?? '';
        $this->updated_at = $attributes['updated_at'] ?? '';
        $this->deleted_at = $attributes['deleted_at'] ?? null;
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
            'payload' => $this->payload,
            'bloggable_type' => $this->bloggable_type,
            'bloggable_id' => $this->bloggable_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
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
