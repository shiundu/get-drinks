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




Route::group(['prefix' => 'v1'], function () {

   Route::get('/product_image/{id}', function (Request $request) {
    	return public_path('images/products/'.$request->id.'.jpg');
	});

   Route::get('/products', 'api\ApiProductController@index');
});