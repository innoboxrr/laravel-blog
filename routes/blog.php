<?php

use Illuminate\Support\Facades\Route;
use Innoboxrr\LaravelBlog\Http\Controllers\BlogController;
use Innoboxrr\LaravelBlog\Http\Livewire\BlogIndex;
use Innoboxrr\LaravelBlog\Http\Livewire\BlogPost;

Route::domain('blog.{domain}')->where(['domain' => '.+'])->group(function () {
    Route::get('blog-assets/{theme}/{folder}/{path}', [BlogController::class, 'assets'])->name('assets');
    Route::get('/', BlogIndex::class)->name('index');
    Route::get('/post/{postSlug}', BlogPost::class)->name('post');
});