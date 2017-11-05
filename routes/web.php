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


Route::resource('products', 'ProductController');

Route::resource('orders', 'OrderController');
Route::get('orders/{order_id}/{status}', 'OrderController@editStatus');

Route::resource('companies', 'CompanyController');

Route::resource('customers', 'CustomerController');
