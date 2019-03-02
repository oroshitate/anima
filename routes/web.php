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

// 認証
Auth::routes();
Route::get('/', 'HomeController@index')->name('home');
Route::get('login/{provider}', 'Auth\SocialAccountController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\SocialAccountController@handleProviderCallback');

// 検索
Route::post('search/{keyword}', 'SearchController@index')->name('search');

// ユーザー
Route::get('user/{nickname}', 'UserController@index')->name('user');
Route::post('mypage/edit', 'UserController@edit')->middleware('auth')->name('mypage');
Route::post('mypage/store', 'UserController@store')->middleware('auth');

// アカウント
Route::get('account/setting', 'AccountController@index')->middleware('auth')->name('account');
Route::get('account/setting/confirm', 'AccountController@confirm')->middleware('auth');
Route::post('account/setting/delete', 'AccountController@delete')->middleware('auth');

// フォロー
Route::get('user/{nickname}/followings', 'FollowController@showFollowings')->name('user.followings');
Route::get('user/{nickname}/followers', 'FollowController@showFollowers')->name('user.followers');
Route::post('follow/store', 'FollowController@store')->middleware('auth');
Route::post('follow/delete', 'FollowController@delete')->middleware('auth');

// 作品
Route::get('item/{item_id}', 'ItemController@index')->name('item');

// レビュー
Route::get('review/{review_id}', 'ReviewController@index')->name('review');
Route::post('review/store', 'ReviewController@store')->middleware('auth');
Route::post('review/edit', 'ReviewController@edit')->middleware('auth');
Route::post('review/delete', 'ReviewController@delete')->middleware('auth');

// コメント
Route::post('comment/store', 'CommentController@store')->middleware('auth');
Route::post('comment/edit', 'CommentController@edit')->middleware('auth');
Route::post('comment/delete', 'CommentController@delete')->middleware('auth');

// いいね
Route::post('like/store', 'LikeController@store')->middleware('auth');
Route::post('like/delete', 'LikeController@delete')->middleware('auth');

// Ajax
Route::post('ajax/timelines/show', 'AjaxController@showMoreTimelines');
Route::post('ajax/keyword-items/show', 'AjaxController@showMoreKeywordItems');
Route::post('ajax/keyword-users/show', 'AjaxController@showMoreKeywordUsers');
Route::post('ajax/reviews/show', 'AjaxController@showMoreReviews');
Route::post('ajax/comments/show', 'AjaxController@showMoreComments');

// その他
