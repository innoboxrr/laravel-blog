<?php

namespace Innoboxrr\LaravelBlog\Http\Livewire\Sub;

use Livewire\Component;

class ExampleSubComponent extends Component
{
    public $message = 'Hola desde SubComponente de Livewire en el Paquete';

    public function render()
    {
        return view('laravel-blog::livewire.sub.example-sub-component');
    }
}
