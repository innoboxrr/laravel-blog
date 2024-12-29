<?php

use Illuminate\Support\Facades\Route;

Route::get('policies', 'BlogCategoryController@policies')
	->name('policies');

Route::get('policy', 'BlogCategoryController@policy')
	->name('policy');

Route::get('index', 'BlogCategoryController@index')
	->name('index');

Route::get('show', 'BlogCategoryController@show')
	->name('show');

Route::post('create', 'BlogCategoryController@create')
	->name('create');

Route::put('update', 'BlogCategoryController@update')
	->name('update');

Route::delete('delete', 'BlogCategoryController@delete')
	->name('delete');

Route::post('restore', 'BlogCategoryController@restore')
	->name('restore');

Route::delete('force-delete', 'BlogCategoryController@forceDelete')
	->name('force.delete');

Route::post('export', 'BlogCategoryController@export')
	->name('export');