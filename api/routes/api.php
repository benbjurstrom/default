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

Route::middleware('api')->prefix('v1')->namespace('Api\V1')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Unauthenticated Routes
    |--------------------------------------------------------------------------
    |
    |
    */

    //

    /*
    |--------------------------------------------------------------------------
    | Authenticated Routes
    |--------------------------------------------------------------------------
    |
    |
    */

    Route::middleware('auth:api')->group(function () {
        Route::prefix('user')->namespace('User')->group(function () {
            Route::get('/user', 'CurrentUserController@show')->name('currentUser');
        });
    });
});
