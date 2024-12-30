<?php

use Illuminate\Support\Facades\Route;

Route::get('policies', 'BlogSubscriberController@policies')
	->name('policies');

Route::get('policy', 'BlogSubscriberController@policy')
	->name('policy');

Route::get('index', 'BlogSubscriberController@index')
	->name('index');

Route::get('show', 'BlogSubscriberController@show')
	->name('show');

Route::post('create', 'BlogSubscriberController@create')
	->name('create');

Route::put('update', 'BlogSubscriberController@update')
	->name('update');

Route::delete('delete', 'BlogSubscriberController@delete')
	->name('delete');

Route::post('restore', 'BlogSubscriberController@restore')
	->name('restore');

Route::delete('force-delete', 'BlogSubscriberController@forceDelete')
	->name('force.delete');

Route::post('export', 'BlogSubscriberController@export')
	->name('export');