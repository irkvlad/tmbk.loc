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

Route::get('speedy/','Api\SpeedyMoonController@getMoon');
Route::get('speedy/week','Api\SpeedyMoonController@getWeek');
Route::get('speedy/day','Api\SpeedyMoonController@getDay');

Route::post('login','Api\Auth\LoginController@login');
