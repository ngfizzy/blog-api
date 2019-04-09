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

  Route::group(['prefix' => 'v1', 'middleware' => 'api'], function() {
          Route::post('users', 'API\UserController@store');
          Route::post('users/auth/login', 'API\UserController@login');
          // Route::middleware('auth')->get('/user', function (Request $request) {
          //     return $request->user();
          // });

          Route::middleware('auth')->get('/test', function (Request $request) {
            return response(['message' => 'welcome']);
          });
  });
