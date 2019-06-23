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

Route::post('/token', '\App\Http\Controllers\Api\UserController@authenticate');

Route::middleware(['jwt.auth'])->group(function ($router) {
    Route::post('/register', '\App\Http\Controllers\Api\UserController@register');
    Route::get('/me', '\App\Http\Controllers\Api\UserController@me');
    Route::get('/users', '\App\Http\Controllers\Api\UserController@index');
    Route::put('/users/{user}', '\App\Http\Controllers\Api\UserController@update');
    Route::delete('/users/{user}', '\App\Http\Controllers\Api\UserController@delete');
    Route::get('/candidates', '\App\Http\Controllers\Api\CandidateController@index');
    Route::post('/candidates', '\App\Http\Controllers\Api\CandidateController@store');
    Route::post('/candidates/{candidateNumber}', '\App\Http\Controllers\Api\CandidateController@computeVote');
    Route::get('/votes', '\App\Http\Controllers\Api\CandidateController@index');
    Route::put('/candidates/{candidate}', '\App\Http\Controllers\Api\CandidateController@update');
    Route::delete('/candidates/{candidate}', '\App\Http\Controllers\Api\CandidateController@delete');
});
