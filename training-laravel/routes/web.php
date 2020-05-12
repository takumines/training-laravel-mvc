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
// Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
// Route::post('login', 'Auth\LoginController@login')->middleware('user_status_check');
// Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
// Route::post('register', 'Auth\RegisterController@register');
Route::get('login/twitter', 'Auth\LoginController@redirectToTwitterProvider')->name('auth.twitter');
Route::get('login/twitter/callback', 'Auth\LoginController@handleTwitterProviderCallback');
// Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
// Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
// Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
// Route::post('password/reset', 'Auth\ResetPasswordController@reset');

/*
|--------------------------------------------------------------------------
| User 認証済み
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => 'user_status_check'], function() {
//----------------- post --------------------------------------------------
    Route:: group(['middleware' => 'auth:user'], function() {

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
        Route::get('/', 'PostController@index')->name('admin.post.list');
        Route::get('/post/{post}', 'PostController@show')->name('admin.post.show');
        Route::delete('/post/{post}',   'PostController@destroy')->name('admin.post.delete');
    // -------------------------- tag ---------------------------------------
        Route::get('/tag/search/{tag}', 'TagController@index')->name('admin.tag.search');
        Route::delete('/tag/{tag}', 'TagController@destroy')->name('admin.tag.delete');
    // -------------------------- user --------------------------------------
        Route::get('/users', 'UserController@index')->name('admin.users');
        Route::delete('/users/{user}', 'UserController@destroy')->name('admin.user.delete');
        Route::put('/users/{user}/suspension', 'UserController@chengeSuspension')->name('admin.user.suspension');
        Route::put('/users/{user}/active', 'UserController@chengeActive')->name('admin.user.active');
        Route::post('logout', 'LoginController@logout')->name('admin.logout');
    });
});
