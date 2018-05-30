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

// Route::group(['middleware' => ['api','cors']], function () {
//     Route::post('auth/register', 'Auth\RegisterController@create');
// });

Route::post('auth/register', 'Auth\RegisterController@register');
Route::post('auth/update', 'Auth\RegisterController@update');
Route::post('auth/addUser', 'Auth\AddUserController@addUser');
Route::post('auth/login', 'Auth\LoginController@login');
Route::post('auth/logout', 'Auth\LoginController@logout');
Route::post('auth/delete', 'Auth\DeleteUserController@destroy');
Route::post('auth/setpassword', 'Auth\SetPasswordController@setpassword');
Route::post('auth/users', 'Auth\UserDetailsController@users');

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
