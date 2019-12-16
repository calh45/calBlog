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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/deleteComment', 'CommentController@delete')->name("comment.delete");

Route::post('/deletePost', 'PostController@delete')->name("post.delete");

Route::get('/post/{id}', 'PostController@index')->name("post.index");

Route::post('/createComment/', 'CommentController@create')->name('comment.create');

Route::post('/editComment', 'CommentController@edit')->name('comment.edit');

Route::post('/createPost', 'PostController@create')->name('post.create');

Route::post('/editPost', 'PostController@edit')->name('post.edit');
