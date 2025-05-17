<?php

use Illuminate\Support\Facades\Route;
use Innoboxrr\LaravelBlog\Http\Controllers\BlogController;
use Innoboxrr\LaravelBlog\Http\Livewire\BlogIndex;
use Innoboxrr\LaravelBlog\Http\Livewire\BlogContact;
use Innoboxrr\LaravelBlog\Http\Livewire\BlogPost;
use Innoboxrr\LaravelBlog\Http\Livewire\BlogCategory;

Route::get('blog/{blog}', BlogIndex::class)->name('app.index');
Route::get('blog/{blog}/contact', BlogContact::class)->name('app.contact');
Route::get('blog/{blog}/post/{post}', BlogPost::class)->name('app.post');
Route::get('blog/{blog}/category/{category}', BlogCategory::class)->name('app.category');
Route::get('blog-assets', [BlogController::class, 'assets'])->name('app.assets');