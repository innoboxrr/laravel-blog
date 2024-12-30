<?php

namespace Innoboxrr\LaravelBlog\Support\DTOs;

use Innoboxrr\Traits\DtoTrait;

class BlogDto
{
    use DtoTrait;

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

        $this->setData();
    }
}
