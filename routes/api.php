<?php

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

Route::post('/login', 'AuthController@login');
Route::get('/logout/{user_id}', 'AuthController@logout');
Route::post('/register', 'AuthController@register');
Route::post('/support', 'SupportController@save');

Route::group(['middleware' => 'jwt.verify'], static function( $router){
    Route::get('/users', 'UserController@getUsers');
    Route::get('/user/{user_id}', 'UserController@getUser');
    Route::get('/menus', 'MenuController@getMenus');
    Route::get('/menu/{menu_id}', 'MenuController@getMenu');
    Route::get('/contents', 'ContentController@getContents');
    Route::get('/content/{content_id}', 'ContentController@getContent');
    Route::get('/content/menu/{content_id}', 'ContentController@getContentByMenu');
    Route::post('/menus', 'MenuController@save');
    Route::post('/content', 'ContentController@save');
});
