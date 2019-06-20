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

Route::post('/token', '\App\Http\Controllers\Api\TokenController@authenticate');

Route::middleware(['jwt.auth'])->group(function ($router) {
    Route::post('/register', '\App\Http\Controllers\Api\TokenController@register');
    Route::post('/me', '\App\Http\Controllers\Api\TokenController@me');
});
