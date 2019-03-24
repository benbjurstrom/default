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
        Route::post('token', 'TokenController@store')->name('auth.token.store');
        Route::post('register', 'RegistrationController@store')->name('auth.register');
        Route::get('agreements', 'AgreementController@index')->name('auth.agreements.index');

        Route::prefix('password')->namespace('Password')->group(function () {
            Route::post('reset', 'ResetController@store')->name('auth.password.reset.store');
            Route::patch('reset', 'ResetController@update')->name('auth.password.reset.update');
            Route::get('reset', 'ResetController@index')->name('auth.password.reset.index');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Authenticated Unverified Routes
    |--------------------------------------------------------------------------
    |
    |
    */

    Route::middleware('auth:api')->group(function () {
        Route::prefix('auth')->namespace('Auth')->group(function () {
            Route::delete('token', 'TokenController@destroy')->name('auth.token.destroy');
            Route::patch('token', 'TokenController@update')->name('auth.token.update');

            Route::get('user', 'UserController@show')->name('auth.user.show');

            Route::prefix('email')->namespace('Email')->group(function () {
                Route::get('verify', 'VerificationController@index')->name('auth.email.verify.index');
                Route::patch('verify', 'VerificationController@update')->name('auth.email.verify.update');
            });
        });
    });


    /*
    |--------------------------------------------------------------------------
    | Routes that require a valid user
    |--------------------------------------------------------------------------
    | Valid user is defined as passing the following middleware
    | 1. Authenticated with the API guard
    | 2. Verified email
    | 3. Accepted latest terms and conditions
    |
    */
    Route::middleware('valid')->group(function () {
        Route::prefix('auth')->namespace('Auth')->group(function () {
            Route::prefix('email')->namespace('Email')->group(function () {
                Route::get('change', 'ChangeController@index')->name('auth.email.change.index');
                Route::post('change', 'ChangeController@store')->name('auth.email.change.store');
                Route::patch('change', 'ChangeController@update')->name('auth.email.change.update');
                Route::delete('change', 'ChangeController@destroy')->name('auth.email.change.destroy');
            });

            Route::prefix('password')->namespace('Password')->group(function () {
                Route::patch('change', 'ChangeController@update')->name('auth.password.change.update');
            });
        });
    });

});