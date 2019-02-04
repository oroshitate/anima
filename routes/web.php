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

// Route::get('/', function() {
//    // $users = App\User::all();
//    // return View::make('users')->with('users', $users);
//    // ログをslackにも投稿
//    // Log::emergency('An informational message.');
// });

Route::get('/', 'PostsController@index')->name('top');

// 投稿画面
Route::resource('posts', 'PostsController', ['only' => ['create', 'store', 'show', 'edit', 'update','destroy']]);

// コメント画面
Route::resource('comments', 'CommentsController', ['only' => ['store']]);
