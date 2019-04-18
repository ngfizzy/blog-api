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

  Route::get('posts', 'API\PostController@index');
  Route::middleware('auth:api')->get('posts/trashed', 'API\PostController@showTrashed');
  Route::get('posts/{id}', 'API\PostController@view');
  Route::middleware('auth:api')->post('posts', 'API\PostController@create');
  Route::middleware('auth:api')->put('posts/{id}', 'API\PostController@update');
  Route::middleware('auth:api')->delete('posts/{id}', 'API\PostController@delete');
  Route::middleware('auth:api')->delete('posts/trash/{id}', 'API\PostController@trash');
  Route::middleware('auth:api')->patch('posts/trash/{id}', 'API\PostController@restore');

  Route::get('categories', 'API\CategoryController@index');
  Route::get('categories/{id}', 'API\CategoryController@view');
  Route::middleware('auth:api')->post('categories', 'API\CategoryController@create');
  Route::middleware('auth:api')->put('categories/{id}', 'API\CategoryController@update');

  Route::get('posts/categories/{categoryId}', 'API\PostCategoryController@viewCategoryPosts');
  Route::middleware('auth:api')->post('posts/categories/', 'API\PostCategoryController@create');
  Route::middleware('auth:api')->delete(
    'posts/{postId}/categories/{categoryId}',
    'API\PostCategoryController@remove');

  Route::get('tags/{tagId}/posts', 'API\PostTagController@viewTagPosts');
  Route::middleware('auth:api')->post('posts/tags', 'API\PostTagController@create');
  Route::middleware('auth:api')->delete(
    'posts/{postId}/tags/{tagId}',
    'API\PostTagController@remove');
});
