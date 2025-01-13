<?php

namespace Innoboxrr\LaravelBlog\Http\Livewire;

use Livewire\Component;

class ExampleComponent extends Component
{
    public $message = 'Hola desde Livewire en el Paquete';

    public function render()
    {
        return view('laravel-blog::livewire.example-component') 
            ->extends('laravel-blog::layouts.app')
            ->section('content');
    }
}
