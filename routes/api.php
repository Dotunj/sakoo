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
Route::post('/login', 'API\AuthController@login')->name('login');
Route::post('/drift/conversation/started', 'API\DriftController@notifyUserConversationStarted');


Route::group(['middleware' => 'auth', 'namespace' => 'API'], function() {
    Route::get('/drift/install', 'DriftController@setup');
    Route::post('/phone-number/create', 'PhoneNumberController@create')->name('create.phone.number');
    Route::get('/phone-number/edit/{number}', 'PhoneNumberController@edit')->name('edit.phone.number');
    Route::put('/phone-number/update/{number}', 'PhoneNumberController@update')->name('update.phone.number');
    Route::delete('/phone-number/delete/{number}', 'PhoneNumberController@delete')->name('delete.phone.number');
    Route::post('/subscription/create', 'SubscriptionController@create')->name('create.subscription');
    Route::post('/subscription/cancel', 'SubscriptionController@cancel')->name('cancel.subscription');
    Route::post('/subscription/resume', 'SubscriptionController@resume')->name('resume.subscription');
});
