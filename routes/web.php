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
Route::get('/forum/{id}/{type}_{filter}_{order}/{page?}', 'ForumController@show')
    ->where([
        'id' => '[0-9]+',
        'type' => 'all|[0-9]+',
        'filter' => 'all|good|top',
        'order' => 'common|latest|hot',
        'page' => '[0-9]+'
    ])
    ->name('forum');
Route::get('/forum/{id}/create', 'ForumController@create');
Route::post('/forum/topics', 'ForumController@store');
Route::get('/forum_group_{id}', 'ForumController@group')->name('forumGroup');
