<?php

use Illuminate\Support\Facades\Route;
use Innoboxrr\LaravelBlog\Http\Livewire\BlogIndex;
use Innoboxrr\LaravelBlog\Http\Livewire\BlogPost;

Route::get('blog/{slug}', BlogIndex::class)->name('blog.index');
Route::get('blog/{slug}/post/{postSlug}', BlogPost::class)->name('blog.post');
