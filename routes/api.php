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
    Route::get('/password/reset/{token}', ['as' => 'password.reset', 'uses' => 'Auth\ResetPasswordController@showResetForm']);
    Route::post('/password/reset', 'Auth\ResetPasswordController@reset');
});

// TODO ADD AUTH MIDDLEWARES
Route::group(['middleware' => ['auth:api']], function() {
    // USERS
    Route::get('/users/{id}', 'UserController@getUserById');

    Route::get('/users', 'UserController@gatAllUsers');

    Route::post('/users', 'UserController@registerUser');

    Route::post('/users/{id}', 'UserController@updateUser');

    Route::delete('/users/{id}', 'UserController@deleteUser');

    // CLIENTS
    Route::get('/clients', 'ClientController@getClients');

    Route::get('/clients/all', 'ClientController@getAllClients');

    Route::post('/clients', 'ClientController@createClient');

    // PRISE_LIST
    Route::get('/price-list', 'PriceListController@getAll');

    Route::post('/price-list', 'PriceListController@create');

    Route::post('/price-list/image', 'PriceListController@storeEquipmentImage');

    Route::put('/price-list/{id}', 'PriceListController@update');

    Route::put('/price-list/{id}/restore', 'PriceListController@restore');

    Route::delete('/price-list/{id}', 'PriceListController@delete');

    // PRISE_LIST_LOGS
    Route::get('/price-list/logs', 'PriceListLogController@getLogs');

    // ORDERS
    Route::get('/order/dollar-rate', 'OrderController@dollarRate');

    Route::get('/order/{id}', 'OrderController@getOrder');

    Route::get('/orders', 'OrderController@getOrders');

    Route::post('/orders/image', 'OrderController@uploadImage');

    Route::post('/orders', 'OrderController@createOrder');

    Route::put('/orders/{id}', 'OrderController@updateOrder');

    Route::delete('/orders/{id}', 'OrderController@deleteOrder');

    // CACHED_DATA
    Route::get('/cache', 'CachedDataController@getCachedData');

    Route::post('/cache', 'CachedDataController@addCachedData');
});