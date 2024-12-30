<?php

namespace Innoboxrr\LaravelBlog\Models\Traits\Operations;

trait BlogSubscriberOperations
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