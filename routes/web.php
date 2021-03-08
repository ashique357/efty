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
Auth::routes(['verify' => true]);
Route::get('/find','FindController@index');
Route::get('/transport/add','TransportController@add');
Route::get('/transports','TransportController@show');
Route::get('/bus/add','BusController@add');
Route::post('/bus/add','BusController@saveBus');
Route::get('/buses','BusController@show');
Route::get('/transport/pending','TransportController@pending');
Route::get('/transport/_dispatch','TransportController@_dispatch');
Route::post('/transport/_dispatch','TransportController@_dispatch_save');
Route::post('/transport/add','TransportController@save');
// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/bus/edit/{bus}','BusController@edit');
Route::get('/bus/{bus}/seats','SeatController@show');
Route::post('/bus/edit/{bus}','BusController@editSave');
Route::post('/bus/delete/{bus}','BusController@delete');
Route::post('/transport/delete/{transport}','TransportController@delete');
Route::get('/booking/{bus}','BookingController@index');
Route::post('/checkout','CheckoutController@index');
Route::get('/checkout','CheckoutController@checkout');
Route::post('/charge','CheckoutController@charge');
Route::get('/charge/complete','CheckoutController@complete');
Route::get('/about', function(){
    return view('about');
});
Route::get('/gallery', function(){
    return view('gallery');
});
