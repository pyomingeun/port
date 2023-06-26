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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/reg_emailcheck', 'AuthController@reg_emailcheck')->name('reg_emailcheck');
Route::post('/oldPwdcheck', 'AuthController@oldPwdcheck')->name('oldPwdcheck');
Route::post('/customer_profile_update', 'CustomerController@customer_profile_update')->name('customer_profile_update');


Route::get('/get-data-for-map-pin/{id}', 'HomeController@show')->name('api-data-for-map-pin');