<?php

use Illuminate\Support\Facades\Route;
use Innoboxrr\LaravelBlog\Http\Livewire\BlogIndex;
use Innoboxrr\LaravelBlog\Http\Livewire\BlogPost;

Route::domain('blog.{domain}')->where(['domain' => '.+'])->group(function () {
    Route::get('/', BlogIndex::class)->name('index');
    Route::get('/post/{postSlug}', BlogPost::class)->name('post');
});



