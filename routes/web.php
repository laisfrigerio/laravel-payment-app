<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::namespace('Admin')->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
    
    
    Route::prefix("payments")->group(function () {
        Route::post('/pay', 'PaymentController@pay')->name('pay');
        Route::get('/capture/{orderId}', 'PaymentController@capture')->name('capture');
        Route::get('/details/{orderId}', 'PaymentController@details')->name('details');
        Route::get('/approval', 'PaymentController@approval')->name('approval');
        Route::get('/cancelled', 'PaymentController@cancelled')->name('cancelled');
    });
});
