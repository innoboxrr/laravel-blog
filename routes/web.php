<?php

use Illuminate\Support\Facades\Route;

use Innoboxrr\LaravelBlog\Http\Livewire\{
    ExampleComponent
};

Route::get('test', ExampleComponent::class);