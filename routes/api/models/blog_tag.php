<?php

use Illuminate\Support\Facades\Route;

Route::get('policies', 'BlogTagController@policies')
	->name('policies');

Route::get('policy', 'BlogTagController@policy')
	->name('policy');

Route::get('index', 'BlogTagController@index')
	->name('index');

Route::get('show', 'BlogTagController@show')
	->name('show');

Route::post('create', 'BlogTagController@create')
	->name('create');

Route::put('update', 'BlogTagController@update')
	->name('update');

Route::delete('delete', 'BlogTagController@delete')
	->name('delete');

Route::post('restore', 'BlogTagController@restore')
	->name('restore');

Route::delete('force-delete', 'BlogTagController@forceDelete')
	->name('force.delete');

Route::post('export', 'BlogTagController@export')
	->name('export');