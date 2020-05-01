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

/*
|--------------------------------------------------------------------------
| User 認証済み
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => 'auth:user'], function() {
//----------------- post --------------------------------------------------
    Route::get('/', 'PostController@index')->name('post.list');
    Route::get('/post/create',      'PostController@create')->name('post.create');
    Route::post('/post/create',     'PostController@store');
    Route::get('/post/{post}',      'PostController@show')->name('post.show');
    Route::get('/post/{post}/edit', 'PostController@edit')->name('post.edit')->middleware('can:update,post');
    Route::put('/post/{post}/edit', 'PostController@update')->middleware('can:update,post');
    Route::delete('/post/{post}',   'PostController@destroy')->name('post.delete')->middleware('can:delete,post');
// ----------------- tag --------------------------------------------------
    Route::get('/tag/create',       'TagController@create')->name('tag.create');
    Route::post('/tag/create',      'TagController@store');
    Route::get('/tag/search/{tag}', 'TagController@index')->name('tag.search');
});

/*
|--------------------------------------------------------------------------
| Admin 認証不要
|--------------------------------------------------------------------------
*/

Route::namespace('Admin')->prefix('admin')->group(function() {
    Route::get('/', function() {return redirect('/admin/home');});
    Route::get('login',  'LoginController@showLoginForm')->name('admin.login');
    Route::post('login', 'LoginController@login');

/*
|--------------------------------------------------------------------------
| Admin 認証済み
|--------------------------------------------------------------------------
*/

    Route::group(['middleware' => 'auth:admin'], function() {
        Route::post('logout', 'LoginController@logout')->name('admin.logout');
        Route::get('/', 'PostController@index')->name('admin.post.list');
        Route::get('/post/{post}', 'PostController@show')->name('admin.post.show');
        Route::get('home',    'HomeController@index')->name('admin.home');
    });
});
