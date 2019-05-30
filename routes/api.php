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
    Route::post('index', 'Api\V1\IndexController@index');
    Route::post('bookList', 'Api\V1\BookController@index');
    Route::post('detail', 'Api\V1\BookController@detail');
    Route::post('bookContent', 'Api\V1\BookController@bookContent');
    Route::post('chapterList', 'Api\V1\BookController@chapterList');
    Route::post('search', 'Api\V1\BookController@search');

    Route::post('index_v2', 'Api\V2\IndexController@index');
    Route::post('bookList_v2', 'Api\V2\BookController@index');
    Route::post('detail_v2', 'Api\V2\BookController@detail');
    Route::post('bookContent_v2', 'Api\V2\BookController@bookContent');
    Route::post('chapterList_v2', 'Api\V2\BookController@chapterList');
    Route::post('search_v2', 'Api\V2\BookController@search');

    Route::post('index_v3', 'Api\V3\IndexController@index');
    Route::post('bookList_v3', 'Api\V3\BookController@index');
    Route::post('detail_v3', 'Api\V3\BookController@detail');
    Route::post('bookContent_v3', 'Api\V3\BookController@bookContent');
    Route::post('chapterList_v3', 'Api\V3\BookController@chapterList');
    Route::post('search_v3', 'Api\V3\BookController@search');

    Route::post('doLogin', 'Api\LoginController@doLogin');
    Route::post('doReg', 'Api\LoginController@doReg');
});


