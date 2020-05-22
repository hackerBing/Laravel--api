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

	// Route::any('/','Home\User\UserController@test');


// 用户登录
Route::post('/login', 'Home\User\UserController@login');

Route::namespace('Home')->middleware(['home.auth.token'])->group(function()
{
	Route::resource('/user', 'User\UserController');
});
