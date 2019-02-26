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

    Route::prefix('auth')->namespace('Auth')->group(function () {
        Route::post('login', 'TokenController@store')->name('auth.login');
        Route::post('register', 'RegistrationController@store')->name('auth.register');
        Route::post('password/reset', 'ForgotPasswordController@store')->name('auth.password.reset');
    });

    /*
    |--------------------------------------------------------------------------
    | Authenticated Routes
    |--------------------------------------------------------------------------
    |
    |
    */

    Route::middleware('auth:api')->group(function () {

        Route::prefix('auth')->namespace('Auth')->group(function () {
            Route::delete('logout', 'TokenController@destroy')->name('auth.logout');
            Route::patch('refresh', 'TokenController@update')->name('auth.refresh');
        });

        Route::prefix('user')->namespace('User')->group(function () {
            Route::get('/', 'CurrentUserController@show')->name('currentUser');
        });

    });
});
