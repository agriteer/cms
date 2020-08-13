<?php

use Illuminate\Http\Request;
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

Route::get('/users', 'UserController@users');

Route::get('/user/{user_id}', 'UserController@user');

Route::get('/menus', 'MenuController@menus');

Route::post('/menus', 'MenuController@save');

Route::get('/menu/{menu_id}', 'MenuController@menu');

Route::get('/contents', 'ContentController@contents');

Route::get('/content/{menu_id}', 'ContentController@conten');

Route::post('/content', 'ContentContrller@save');
