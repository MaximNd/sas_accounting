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

// TODO ADD AUTH MIDDLEWARES
Route::get('/users/{id}', 'UserController@getUserById');

Route::get('/users', 'UserController@gatAllUsers');

Route::post('/users', 'UserController@registerUser');