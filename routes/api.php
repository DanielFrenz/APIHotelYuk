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

Route::post('register', 'Api\AuthController@register');
Route::post('login', 'Api\AuthController@login')->name('login');

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('hotel', 'Api\HotelController@index');
    Route::get('hotel/{id}', 'Api\HotelController@show');

    Route::get('hotel/{hotelId}/kamar', 'Api\KamarController@index');
    Route::get('hotel/{hotelId}/kamar/{id}', 'Api\KamarController@show');

    Route::get('hotel/{hotelId}/review', 'Api\ReviewController@indexHotel');
    
    Route::get('user/review', 'Api\ReviewController@indexUser');
    
    Route::put('user', 'Api\UserController@update');
    Route::get('logout', 'Api\AuthController@logout');
});

Route::post('hotel', 'Api\HotelController@store');
Route::put('hotel/{id}', 'Api\HotelController@update');
Route::delete('hotel/{id}', 'Api\HotelController@destroy');

Route::post('kamar', 'Api\KamarController@store');
Route::put('kamar/{id}', 'Api\KamarController@update');
Route::delete('kamar/{id}', 'Api\KamarController@destroy');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
