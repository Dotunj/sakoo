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

Route::post('/register', 'API\AuthController@register')->name('register.user');
Route::post('/login', 'API\AuthController@login')->name('login.user');
Route::post('/drift/conversation/started', 'API\DriftController@notifyUserConversationStarted');
Route::get('/drift/install', 'API\DriftController@setup');
Route::get('/phone-number/create', 'API\PhoneNumberController@create');
Route::get('/phone-number/edit/{number}', 'API\PhoneNumberController@edit');
Route::put('/phone-number/update/{number}', 'API\PhoneNumberController@update');
Route::delete('/phone-number/delete/{number}', 'API\PhoneNumberController@delete');
