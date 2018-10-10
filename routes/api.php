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
Route::group(['middleware'=>['cross','checkHeader']],function() {
    Route::post('index', 'Api\IndexController@index');
    Route::post('bookList', 'Api\BookController@index');
    Route::post('detail', 'Api\BookController@detail');
    Route::post('bookContent', 'Api\BookController@bookContent');
    Route::post('search', 'Api\BookController@search');
    Route::post('doLogin', 'Api\LoginController@doLogin');
    Route::post('doReg', 'Api\LoginController@doReg');
});
