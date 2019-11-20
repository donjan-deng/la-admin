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
Route::apiResource('users', 'Api\UserController', ['only' => ['index', 'show', 'update']])->middleware('client');
//Route::apiResource('users', 'Api\UserController', ['except' =>['create', 'destroy']]);
