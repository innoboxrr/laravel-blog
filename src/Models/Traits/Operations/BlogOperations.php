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

}
