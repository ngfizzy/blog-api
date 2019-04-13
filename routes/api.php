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

  Route::middleware('auth:api')->post('posts', 'API\PostController@create');
  Route::middleware('auth:api')->put('posts/{id}', 'API\PostController@update');
  Route::middleware('auth:api')->delete('posts/{id}', 'API\PostController@delete');
  Route::middleware('auth:api')->delete('posts/trash/{id}', 'API\PostController@trash');
  Route::get('posts', 'API\PostController@index');
  Route::get('posts/{id}', 'API\PostController@view');
});
