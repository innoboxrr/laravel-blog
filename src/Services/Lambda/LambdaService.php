<?php

namespace Innoboxrr\LaravelBlog\Services\Lambda;

/**
 * ACTIONS: 
 *  - getToken
 *  - improvePost
 *  - generateWithAI
 *  - translateWithAI
 *  - transcriptWithAI
 *  - videoToTextAI
 */

use Illuminate\Support\Facades\Http;

class LambdaService
{
    private array $data;
    private string $token;
    private string $endpoint;
    private array $payload; // body to send to lambda

    public function __construct(array $data) // Cambiado _construct a __construct
    {
        $this->data = $data;
        $this->token = config('laravel-blog.lambda_token');
        $this->endpoint = config('laravel-blog.lambda_endpoint');
    }

    public static function handle(array $data)
    {
        $instance = new self($data);
        return $instance->process();
    }

    protected function process()
    {
        $type = $this->data['action'];

        // Buscar la clase que corresponda al tipo de acción
        $class = __NAMESPACE__ . '\\Actions\\' . ucfirst($type) . 'Action';

        if (!class_exists($class)) {
            return response()->json([
                'message' => 'Action not found',
            ], 404);
        }

        $this->payload = $class::handle($this->data);

        return $this->callLambda();
    }

    private function callLambda()
    {
        return Http::withHeaders([
            'Authorization' => $this->token,
        ])->post($this->endpoint, $this->payload);
    }
}
