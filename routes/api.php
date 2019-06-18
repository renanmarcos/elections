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

Route::post('/token', '\App\Http\Controllers\Api\TokenController@authenticate');
Route::post('/register', '\App\Http\Controllers\Api\TokenController@register');

Route::middleware(['jwt.verify'])->group(function ($router) {
    Route::post('/me', '\App\Http\Controllers\Api\TokenController@me');
});
