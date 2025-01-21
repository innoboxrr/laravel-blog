<?php

namespace Innoboxrr\LaravelBlog\Services\Lambda\Actions;

class ImprovePostAction
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public static function handle(array $data)
    {
        $instance = new self($data);
        return $instance->process();
    }

    protected function process()
    {
        // Implementar lógica aquí
    }
}