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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('auth', 'UserController@login');
Route::post('register', 'UserController@register');

Route::group(['middleware' => ['jwt.verify']], function(){
	Route::get('/user', 'UserController@index');
	Route::get('/user/{id}', 'UserController@show');
	Route::put('/user/{id}', 'UserController@edit');
	Route::delete('/user/{id}', 'UserController@destroy');

	Route::get('/product', 'ProductController@index');
	Route::post('/product', 'ProductController@store');
	Route::get('/product/{id}', 'ProductController@show');
	Route::put('/product/{id}', 'ProductController@edit');
	Route::delete('/product/{id}', 'ProductController@destroy');
	Route::post('/product/{id}/buy', 'ProductController@buy');

	Route::get('/transaction', 'TransactionController@index');
	Route::get('/transaction/{id}', 'TransactionController@show');
	Route::post('/transaction/{id}/approve', 'TransactionController@approve');

	Route::get('/point', 'PointController@index');

	Route::get('/reward', 'RewardController@index');
	Route::post('/reward/{id}/buy', 'RewardController@buy');

});
