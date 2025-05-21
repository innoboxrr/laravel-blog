<?php

namespace Innoboxrr\LaravelBlog\Services\Lambda\Actions;

class TranslateWithAIAction
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
        return [
            'type' => 'translateWithAI',
            'data' => [
                'text' => $this->data['payload']['text'],
                'targetLanguage' => $this->data['payload']['targetLanguage'],
                'sourceLanguage' => $this->data['payload']['sourceLanguage'] ?? 'auto',
                'rewrite' => $this->data['payload']['rewrite'] ?? false,
            ],
        ];
    }
}
