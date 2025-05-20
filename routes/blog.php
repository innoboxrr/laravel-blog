<?php

use Illuminate\Support\Facades\Route;
use Innoboxrr\LaravelBlog\Http\Controllers\BlogController;
use Innoboxrr\LaravelBlog\Http\Livewire\BlogIndex;
use Innoboxrr\LaravelBlog\Http\Livewire\BlogLogin;
use Innoboxrr\LaravelBlog\Http\Livewire\BlogContact;
use Innoboxrr\LaravelBlog\Http\Livewire\BlogPost;
use Innoboxrr\LaravelBlog\Http\Livewire\BlogCategory;
use Innoboxrr\LaravelBlog\Http\Livewire\BlogTag;

Route::domain('blog.{domain}')->where(['domain' => '.+'])->group(function () {
    Route::get('/', BlogIndex::class)->name('index');
    Route::get('/login', BlogLogin::class)->name('login');
    Route::post('logout', [BlogController::class, 'logout'])->name('logout');
    Route::get('/contact', BlogContact::class)->name('contact');
    Route::get('/post/{post}', BlogPost::class)->name('post');
    Route::get('/category/{category}', BlogCategory::class)->name('category');
    Route::get('/tag/{tag}', BlogTag::class)->name('tag');
    Route::get('/blog-assets', [BlogController::class, 'assets'])->name('assets');
});