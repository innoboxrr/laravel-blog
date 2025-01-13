<?php

use Illuminate\Support\Facades\Route;
use Innoboxrr\LaravelBlog\Http\Livewire\BlogIndex;
use Innoboxrr\LaravelBlog\Http\Livewire\BlogPostDetail;

Route::group(['middleware' => ['web']], function () {
    // Ruta para blogs en el dominio principal
    Route::get('blog/{slug}', BlogIndex::class)->name('blog.index');
    Route::get('blog/{slug}/post/{postSlug}', BlogPostDetail::class)->name('blog.post');

    // Ruta para dominios personalizados
    Route::domain('{subdomain}.{domain}')
        ->where('subdomain', 'blog')
        ->group(function () {
            Route::get('/', BlogIndex::class)->name('blog.custom.index');
            Route::get('/post/{postSlug}', BlogPostDetail::class)->name('blog.custom.post');
        });
});
