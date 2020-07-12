<?php

use Illuminate\Support\Facades\Route;

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
Route::group([
    'middleware' => 'return-json',
    'prefix' => '1.0',
], function () {
    Route::group([
        'middleware' => 'auth:api',
        'prefix' => 'users',
    ], function () {
        Route::get('me', 'UserController@me');
    });
    Route::post('users/auth/refresh', 'AuthController@refresh');

    Route::post('users/auth', 'AuthController@login');

});
