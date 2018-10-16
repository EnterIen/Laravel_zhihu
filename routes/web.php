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

Route::get('/','QuestionController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

# 问题资源
Route::resource('question','QuestionController');

Route::post('question/{questionId}/update','QuestionController@update')->name('question.update');

//回答
Route::post('question/{questionId}/answer','AnswerController@store')->name('question.answer')->middleware('auth');;

//标签
Route::get('/label/{id}','LabelController@show')->name('label.show');

//用户主页
Route::get('/user/{id?}','UserController@show')->name('user.show');

//用户主页标签
Route::get('/user/{id?}/questions','UserController@show')->name('user.questions');
Route::get('/user/{id?}/answers','UserController@show')->name('user.answers');
Route::get('/user/{id?}/follows','UserController@show')->name('user.follows');	#用户关注
Route::get('/user/{id?}/followers','UserController@show')->name('user.followers');	#用户粉丝

Route::post('/user/avatar','UserController@avatar')->name('user.avatar');	

# 点赞
Route::get('/answer/{id}/like','LikeController@answer')->name('answer.like');

# 关注
Route::get('/follow/{id}/user','FollowController@user')->name('user.follow');
Route::get('/follow/{id}/question','FollowController@question')->name('question.follow');
Route::get('/follow/{id}/label','FollowController@label')->name('label.follow');

# 评论 
Route::get('/answer/{id}/comment','CommentController@answer')->name('answer.comment');
Route::get('/question/{id}/comment','CommentController@question')->name('question.comment');
Route::post('/comment','CommentController@store')->name('comment.store');

#私信
Route::post('/user/message','MessageController@store')->name('user.message');
Route::get('/user/{id}/message','MessageController@show')->name('message.read');

# 通知
Route::get('/notification/show','NotificationController@show')->name('notification.show');
Route::get('/notification/read','NotificationController@read')->name('notification.read');

