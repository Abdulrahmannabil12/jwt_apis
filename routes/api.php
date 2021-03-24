<?php

use Illuminate\Http\Request;
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


Route::group(['middleware' => 'check_password', 'api'], function () {

    Route::group(['prefix' => 'admin'], function () {
        Route::post('login', [\App\Http\Controllers\Api\Admin\AuthController::class, 'login']);

        Route::group(['middleware' => 'auth.guard:admin-api'], function () {
            Route::post('logout', [\App\Http\Controllers\Api\Admin\AuthController::class, 'logout']);
            Route::post('refresh', [\App\Http\Controllers\Api\Admin\AuthController::class, 'refresh']);
            Route::post('me', [\App\Http\Controllers\Api\Admin\AuthController::class, 'me']);

        });


    });
    Route::group(['prefix' => 'user'], function () {
        Route::post('login', [\App\Http\Controllers\Api\User\AuthController::class, 'login']);
        Route::post('register', [\App\Http\Controllers\Api\User\AuthController::class, 'register']);

        Route::group(['middleware' => 'auth.guard:user-api'], function () {
            Route::post('logout', [\App\Http\Controllers\Api\User\AuthController::class, 'logout']);
            Route::post('refresh', [\App\Http\Controllers\Api\User\AuthController::class, 'refresh']);
            Route::post('me', [\App\Http\Controllers\Api\User\AuthController::class, 'me']);
            Route::post('mytoken', [\App\Http\Controllers\Api\User\AuthController::class, 'GetMyToken']);

        });


    });

});
