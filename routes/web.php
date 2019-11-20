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

Route::get('/', 'Home\IndexController@index');
Route::prefix('home')->group(function () {
    Route::any('/captcha', 'Home\IndexController@captcha');
    Route::any('/qrcode', 'Home\IndexController@qrcode');
});
Route::any('manage/login', 'Manage\IndexController@login');
Route::any('manage/logout', 'Manage\IndexController@logout');
Route::prefix('manage')
        ->middleware('auth', 'check.permission')
        ->group(function () {
            Route::any('/index', 'Manage\IndexController@index');
            Route::any('/upload', 'Manage\IndexController@upload');
            Route::any('/editorupload', 'Manage\IndexController@editorUpload');
            //系统管理
            Route::any('/role/list', 'Manage\RoleController@getList');
            Route::any('/role/edit', 'Manage\RoleController@edit');
            Route::any('/role/attach', 'Manage\RoleController@attach');
            Route::any('/role/search', 'Manage\RoleController@search');
            Route::any('/permission/search', 'Manage\PermissionController@search');
            Route::any('/user/list', 'Manage\UserController@getList');
            Route::any('/user/edit', 'Manage\UserController@edit');
            Route::any('/config/list', 'Manage\ConfigController@getList');
            Route::any('/config/edit', 'Manage\ConfigController@edit');
        });
