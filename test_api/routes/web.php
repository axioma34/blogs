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

Route::get('/', function () {
    return view('test_api');
});
Route::post('auth','TestController@auth')->name('auth');
Route::post('posts','TestController@posts')->name('posts');
Route::post('show_post','TestController@show_post')->name('show_post');
Route::post('create_post','TestController@create_post')->name('create_post');
Route::post('delete_post','TestController@delete_post')->name('delete_post');
Route::post('comments','TestController@comments')->name('comments');
Route::post('create_comment','TestController@create_comment')->name('create_comment');
Route::post('delete_comment','TestController@delete_comment')->name('delete_comment');
Route::post('logout','TestController@logout')->name('logout');



