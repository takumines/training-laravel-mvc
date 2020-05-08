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

Route::group(['middleware' => 'api'], function() {
    Route::namespace('Api')->group(function() {
        Route::post('/register', 'Auth\RegisterController@register');
        Route::post('/login', 'Auth\LoginController@login');
        Route::group(['middleware' => 'jwt.auth'], function() {
            Route::get('/', 'PostController@index');
            Route::post('/post/add', 'PostController@store');
            Route::get('/post/{id}', 'PostController@show');
            Route::put('/post/{id}/edit', 'PostController@update');
            Route::delete('/post/{id}', 'PostController@destroy');
        });
    });
});

