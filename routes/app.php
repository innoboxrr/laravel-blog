<?php

use Illuminate\Support\Facades\Route;
use Innoboxrr\LaravelBlog\Http\Controllers\BlogController;
use Innoboxrr\LaravelBlog\Http\Livewire\BlogIndex;
use Innoboxrr\LaravelBlog\Http\Livewire\BlogPost;

Route::get('blog-assets/{theme}/{folder}/{path}', [BlogController::class, 'assets'])->name('app.assets');
Route::get('blog/{blog}', BlogIndex::class)->name('app.index');
Route::get('blog/{blog}/post/{postSlug}', BlogPost::class)->name('app.post');