<?php

namespace Innoboxrr\LaravelBlog\Services\Lambda\Actions;

class GenerateWithAIAction
{
    public function __construct()
    {
        //
    }

    public static function handle(array $data)
    {
        $instance = new self();
        return $instance->process($data);
    }

    protected function process(array $data)
    {
        // Implementar lógica aquí
    }
}