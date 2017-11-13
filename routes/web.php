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

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/', 'OrderController@index');

Route::resource('products', 'ProductController');

Route::resource('orders', 'OrderController');
Route::get('orders/{order_id}/{status}', 'OrderController@editStatus');

Route::resource('companies', 'CompanyController');

Route::resource('customers', 'CustomerController');

Auth::routes();

Route::get('register_istadrinks_users', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::get('register', 'Auth\LoginController@showLoginForm')->name('register');

Route::get('/', 'HomeController@index')->name('home');
