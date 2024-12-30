<?php

use Illuminate\Support\Facades\Route;

Route::get('policies', 'BlogController@policies')
	->name('policies');

Route::get('policy', 'BlogController@policy')
	->name('policy');

Route::get('index', 'BlogController@index')
	->name('index');

Route::get('show', 'BlogController@show')
	->name('show');

Route::post('create', 'BlogController@create')
	->name('create');

Route::put('update', 'BlogController@update')
	->name('update');

Route::delete('delete', 'BlogController@delete')
	->name('delete');

Route::post('restore', 'BlogController@restore')
	->name('restore');

Route::delete('force-delete', 'BlogController@forceDelete')
	->name('force.delete');

Route::post('export', 'BlogController@export')
	->name('export');
