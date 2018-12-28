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

Route::middleware('auth:api')->get('/user', 'UserController@getUser');

Route::group(['middleware' => ['guest']], function() {
    // Forgot Password
//    Route::get('/password/reset', ['as' => 'password.request', 'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm']);
    Route::post('/password/email', ['as' => 'password.email', 'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail']);
    // Reset Password
    Route::get('/password/reset/{token}', ['as' => 'password.reset', 'uses' => 'Auth\ResetPasswordController@showResetForm']);
    Route::post('/password/reset', 'Auth\ResetPasswordController@reset');
});

Route::group(['middleware' => ['auth:api']], function() {
    // USERS
    Route::get('/users/{id}', 'UserController@getUserById');

    Route::get('/users', 'UserController@gatAllUsers');

    Route::get('/users/unique-email/{email}', 'UserController@checkUniqueEmail');

    Route::post('/users', 'UserController@registerUser');

    Route::post('/users/{id}', 'UserController@updateUser');

    Route::delete('/users/{id}', 'UserController@deleteUser');

    // CLIENTS
    Route::get('/clients/all', 'ClientController@getAllClients');

    Route::get('/clients/{id}', 'ClientController@getClient');
    
    Route::get('/clients', 'ClientController@getClients');

    Route::post('/clients', 'ClientController@createClient');

    Route::put('/clients/{id}', 'ClientController@updateClient');

    Route::delete('/clients/{id}', 'ClientController@deleteClient');

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
    Route::get('/order/dollar-rate/{date}', 'OrderController@dollarRate');

    Route::get('/order/{id}', 'OrderController@getOrder');

    Route::get('/orders', 'OrderController@getOrders');

    Route::post('/orders/image', 'OrderController@uploadImage');

    Route::post('/orders', 'OrderController@createOrder');

    Route::put('/orders/{id}', 'OrderController@updateOrder');

    Route::put('/orders/{id}/restore', 'OrderController@restoreOrder');

    Route::delete('/orders/{id}', 'OrderController@deleteOrder');

    // ORDERS PDF
    Route::get('/orders_pdf/{order_id}', 'OrderPDFController@getOrderPDF');

    Route::post('/orders_pdf/{order_id}', 'OrderPDFController@createPDF');

    Route::delete('/orders_pdf/{id}', 'OrderPDFController@deletePDF');

    // ORDERS EXCEL
    Route::post('/orders_excel', 'OrderExcelController@createExcel');

    // ORDERS_LOGS
    Route::get('/orders/logs', 'OrderLogController@getLogs');

    // ORDER_PRICES
    Route::post('/order-prices/{order_id}', 'OrderPricesController@createOrderPrices');

    // CACHED_DATA
    Route::get('/cache', 'CachedDataController@getCachedData');

    Route::post('/cache', 'CachedDataController@addCachedData');

    Route::delete('/cache/{id}', 'CachedDataController@deleteCachedData');
});