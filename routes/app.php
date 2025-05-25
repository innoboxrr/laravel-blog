<?php

use Illuminate\Support\Facades\Route;
use Innoboxrr\LaravelBlog\Http\Controllers\BlogController;
use Innoboxrr\LaravelBlog\Http\Livewire\BlogIndex;
use Innoboxrr\LaravelBlog\Http\Livewire\BlogLogin;
use Innoboxrr\LaravelBlog\Http\Livewire\BlogContact;
use Innoboxrr\LaravelBlog\Http\Livewire\BlogPost;
use Innoboxrr\LaravelBlog\Http\Livewire\BlogCategory;
use Innoboxrr\LaravelBlog\Http\Livewire\BlogTag;

Route::get('blog/{blog}', BlogIndex::class)->name('app.index');
Route::get('blog/{blog}/login', BlogLogin::class)->name('app.login');
Route::post('blog/{blog}/logout', [BlogController::class, 'logout'])->name('app.logout');
Route::get('blog/{blog}/contact', BlogContact::class)->name('app.contact');
Route::get('blog/{blog}/post/{post}', BlogPost::class)->name('app.post');
Route::get('blog/{blog}/category/{category}', BlogCategory::class)->name('app.category');
Route::get('blog/{blog}/tag/{tag}', BlogTag::class)->name('app.tag');
Route::get('blog-assets', [BlogController::class, 'assets'])->name('app.assets');
Route::get('blog/{blog}/subscriber/verify/{subscriber}', [BlogController::class, 'subscriberVerify'])->name('app.subscriber.verify');
