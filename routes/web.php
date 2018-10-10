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


Route::get('/','Home\IndexController@index');
Route::get('login', 'Home\LoginController@showLoginForm')->name('login');
Route::post('login', 'Home\LoginController@login');
Route::post('logout', 'Home\LoginController@logout')->name('logout');

//Route::any('log','Admin\LoginController@log');
//Route::get('log_out','Admin\LoginController@log_out');

/*文件上传*/
Route::any('uploadImg','FileController@uploadImg');


Route::group(['prefix' => 'admin'],function() {
    /*登陆*/
    //Auth::routes();
    Route::get('login', 'Admin\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Admin\LoginController@login');
    Route::post('logout', 'Admin\LoginController@logout')->name('logout');
    /*
    // Registration Routes...
    $this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    $this->post('register', 'Auth\RegisterController@register');

    // Password Reset Routes...
    $this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    $this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    $this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    $this->post('password/reset', 'Auth\ResetPasswordController@reset');*/

    Route::group(['middleware'=>'auth:admin'],function() {

    //    Route::resource('/prompt','Admin\PromptController');
        Route::group(['middleware'=>'clearance'],function() {
            //首页
            Route::get('/','Admin\AdminController@admin');
            //管理员管理
            Route::resource('roles', 'Admin\RoleController');
            Route::resource('permissions', 'Admin\PermissionController');
            Route::resource('users', 'Admin\UserController');
            Route::resource('menu', 'Admin\MenuController');
            Route::resource('work_log', 'Admin\Work_LogController');
            //小说模块
            Route::group(['prefix' => 'book'],function() {
                Route::get('/','Admin\BooksController@index');
                Route::post('del','Admin\BooksController@del');
                Route::post('restore','Admin\BooksController@restore');
                Route::post('sort/{id}','Admin\BooksController@sort')->where('id','[0-9]+');
                Route::any('create','Admin\BooksController@create');
                Route::any('update/{id}','Admin\BooksController@update')->where('id','[0-9]+');
                Route::get('detail/{id}','Admin\BooksController@detail')->where('id','[0-9]+');
                Route::post('execPython/{id}','Admin\BooksController@execPython')->where('id','[0-9]+');
                Route::post('execPythonChapter/{id}','Admin\BooksController@execPythonChapter')->where('id','[0-9]+');
                Route::post('update_chapter/{id}','Admin\BooksController@update_chapter')->where('id','[0-9]+');
            });
            //系统管理
            Route::resource('visitor', 'Admin\VisitorController');
            Route::resource('search_log', 'Admin\Search_LogController');
            Route::resource('feedback', 'Admin\FeedbackController');
            Route::post('feedback/is_read/{id}', 'Admin\FeedbackController@is_read')->where('id','[0-9]+');
        });

    });

});


