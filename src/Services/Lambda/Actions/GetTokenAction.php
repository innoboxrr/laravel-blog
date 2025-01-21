<?php

namespace Innoboxrr\LaravelBlog\Services\Lambda\Actions;

use Illuminate\Support\Js;

class GetTokenAction
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
        return [
            'type' => 'getToken',
        ];
    }
}