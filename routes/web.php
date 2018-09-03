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

use Illuminate\Support\Facades\Route;

Route::get('/', 'IndexController@index')->name('home');
Route::get('/captcha', 'IndexController@captcha')->name('captcha');
Route::get('/debug', 'IndexController@debug');
Route::get('/user', 'UserController@index')->name('userHome');
Route::prefix('user')->group(function () {
    Route::get('/login', 'UserController@login')->name('login');
    Route::post('/login', 'UserController@doLogin');
    Route::get('/register', 'UserController@register')->name('register');
    Route::post('/register', 'UserController@doRegister');
    Route::get('/password/modify', 'UserController@modifyPassword');
    Route::post('/password/modify', 'UserController@doModifyPassword');
});
Route::get('/forum_group_{id}', 'ForumController@group')->name('forumGroup');
Route::get('/forum/{id}/{page?}', 'ForumController@show')->name('forum');
Route::get('/forum/{id}/topics/create', 'TopicController@create');
Route::post('/forum/topics', 'TopicController@store');
Route::get('/forum/topic/{id}/{page}', 'TopicController@show')->where([
    'id' => '[0-9]+',
    'page' => '[0-9]+'
]);
Route::post('/forum/replies', 'ReplyController@store');
