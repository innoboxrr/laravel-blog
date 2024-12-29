<?php

use Illuminate\Support\Facades\Route;

Route::get('policies', 'BlogPostController@policies')
	->name('policies');

Route::get('policy', 'BlogPostController@policy')
	->name('policy');

Route::get('index', 'BlogPostController@index')
	->name('index');

Route::get('show', 'BlogPostController@show')
	->name('show');

Route::post('create', 'BlogPostController@create')
	->name('create');

Route::put('update', 'BlogPostController@update')
	->name('update');

Route::delete('delete', 'BlogPostController@delete')
	->name('delete');

Route::post('restore', 'BlogPostController@restore')
	->name('restore');

Route::delete('force-delete', 'BlogPostController@forceDelete')
	->name('force.delete');

Route::post('export', 'BlogPostController@export')
	->name('export');