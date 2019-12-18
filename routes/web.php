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
use App\Twitter;


app()->singleton("App\Twitter", function ($app) {
    return new Twitter("e336e76e-020a-4821-a699-72fe7f88c38b");
});



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

Route::get("/activity", "ActivityController@index")->name("activity");

Route::get("exampleroute", "apiTestController@exampleMethod");
