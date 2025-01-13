<?php

use Illuminate\Support\Facades\Route;
use Innoboxrr\LaravelBlog\Http\Livewire\BlogIndex;
use Innoboxrr\LaravelBlog\Http\Livewire\BlogPost;

Route::get('/', BlogIndex::class)->name('blog.custom.index');
Route::get('/post/{postSlug}', BlogPost::class)->name('blog.custom.post');
