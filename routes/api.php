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

Route::prefix('v1')->group(function (){
    Route::post('/lots' , 'Api\v1\LotsController@store');
    Route::get('/lots/{id}' , 'Api\v1\LotsController@show');
    Route::get('/lots' , 'Api\v1\LotsController@index');
    Route::post('/trades', 'Api\v1\TradeController@store');
});

