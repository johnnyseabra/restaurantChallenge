<?php

use Illuminate\Support\Facades\Route;

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


Route::get('/orders/create', 'App\Http\Controllers\OrderController@create');
Route::post('/orders/store', 'App\Http\Controllers\OrderController@store')->name('storeOrder');

Route::get('/orders/kitchen', 'App\Http\Controllers\OrderController@listKitchen')->name('kitchen');
Route::post('/orders/kitchen', 'App\Http\Controllers\OrderController@changeStatus')->name('changeOrderStatus');
Route::get('/orders/toten', 'App\Http\Controllers\OrderController@listDone');