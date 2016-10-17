<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

// Auth
Auth::routes();
Route::get('/', 'HomeController@index')->name('home');;

// Home
// Route::get('/', function () {
    // return view('homepage');
// });

// Address
Route::post('address/code', 'AddressController@code');
Route::post('address/add/{idkey}', 'AddressController@store');
Route::get('address/{idkey}', 'AddressController@show');


// Payment
Route::post('payment/add', 'PaymentController@store');
Route::get('payment', 'PaymentController@show');

// Particpants
Route::get('participants/{idkey}', 'PaymentController@participants');

