<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

Route::group(['middleware' => 'auth'], function() {
    Route::get('/', 'PostController@index')->name('post.list');
    Route::get('/post/{post}', 'PostController@show')->name('post.show');
    Route::get('/post/create', 'PostController@create')->name('post.create');
    Route::post('/post/create', 'PostController@store');
    Route::get('/post/{post}/edit', 'PostController@edit')->name('post.edit');
    Route::put('/post/{post}/edit', 'PostController@update');
    Route::delete('/post/{post}', 'PostController@destroy')->name('post.delete');
});


