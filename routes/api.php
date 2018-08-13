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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['guest']], function() {
    // Forgot Password
//    Route::get('/password/reset', ['as' => 'password.request', 'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm']);
    Route::post('/password/email', ['as' => 'password.email', 'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail']);
    // Reset Password
//    Route::get('/password/reset/{token}', ['as' => 'password.reset', 'uses' => 'Auth\ResetPasswordController@showResetForm']);
    Route::post('/password/reset', 'Auth\ResetPasswordController@reset');
});

// TODO ADD AUTH MIDDLEWARES
Route::group(['middleware' => ['auth:api']], function() {
    Route::get('/users/{id}', 'UserController@getUserById');

    Route::get('/users', 'UserController@gatAllUsers');

    Route::post('/users', 'UserController@registerUser');

    Route::post('/users/{id}', 'UserController@updateUser');
});