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

Route::post('auth', 'AuthController@login');
Route::post('register', 'AuthController@register');



Route::group(['middleware' => ['jwt.verify']], function () {

    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::resource('posts', 'PostController');
    Route::resource('comments', 'CommentController');
    Route::post('comments/{id}','CommentController@store');
});