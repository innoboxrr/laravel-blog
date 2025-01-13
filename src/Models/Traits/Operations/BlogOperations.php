<?php

namespace Innoboxrr\LaravelBlog\Models\Traits\Operations;

trait BlogOperations
{

    public function buildPayload()
    {
        return [];
    }

    public function updatePayload()
    {
        $this->payload = $this->buildPayload();
        return $this->save();
    }

    public static function resolveBlog($host, $slug = null)
    {
        return self::where('domain', $host)
            ->orWhere('slug', $slug)
            ->firstOrFail();
    }

}
