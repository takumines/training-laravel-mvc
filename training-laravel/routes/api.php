<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/ping', function() {
    return response()->json(['message' => 'pong']);
});

Route::group(['middleware' => 'api'], function() {
    Route::namespace('Api')->group(function() {
        Route::post('/register', 'Auth\RegisterController@register');
        Route::post('/login', 'Auth\LoginController@login');
        Route::group(['middleware' => 'jwt.auth'], function() {
            Route::get('/', 'PostController@index');
            Route::post('/post/add', 'PostController@store');
            Route::get('/post/{id}', 'PostController@show');
            Route::put('/post/{id}/edit', 'PostController@update')->middleware('can:update,post');
            Route::delete('/post/{id}', 'PostController@destroy')->middleware('can:delete,post');;
        /*-------------------------- tag --------------------------------*/
            Route::get('/tag/search/{id}', 'TagController@index');
            Route::post('/tag/create', 'TagController@store');
        });
    });
});

Route::group(['middleware' => 'api'], function() {
    Route::namespace('Admin\Api')->prefix('admin')->group(function() {
        Route::post('/login', 'Auth\LoginController@login');
        Route::group(['middleware' => 'jwt.auth'], function() {
            Route::get('/', 'PostController@index');
            Route::get('/post/{id}', 'PostController@show');
            Route::delete('/post/{id}', 'PostController@destroy');
        /*----------------------- tag -------------------------------*/
            Route::get('/tag/search/{id}', 'TagController@index');
            Route::delete('/tag/{id}', 'TagController@destroy');
        /*----------------------- user ------------------------------*/
            Route::get('/users', 'UserController@index');
            Route::delete('users/{id}', 'UserController@destroy');
        });
    });
});
