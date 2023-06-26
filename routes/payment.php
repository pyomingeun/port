<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/payment', 'PaymentController@store');

Route::post('/payment/return/{orderid}', 'PaymentController@return');
Route::get('/payment/cancel/{orderid}', 'PaymentController@cancel');
