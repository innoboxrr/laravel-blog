<?php

namespace Innoboxrr\LaravelBlog\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class BlogUserContact
{
    use Dispatchable, SerializesModels;

    public $data;

    public function __construct(array $data)
    {
        $this->data = collect($data);
    }
}
