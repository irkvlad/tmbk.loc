<?php

use Illuminate\Http\Request;
use App\Treck;
use App\Http\Controllers\Appi;

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
//Auth::routes(['register' => false]);//['register' => false]
Route::group(['middleware' => 'auth:api'], function() {
    Route::get('trecks/{treck}', 'Api\TreckController@show');
    Route::get('trecks', 'Api\TreckController@index');
});
Route::post('login', 'Api\LoginController@login');
Route::post('logout', 'Api\LoginController@logout');
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
