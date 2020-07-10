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


Route::post('login', 'ApiController@login');
Route::post('register', 'ApiController@register');
 
Route::group(['middleware' =>['auth:api']],function () {
    Route::get('logout', 'ApiController@logout');
    Route::get('user', 'ApiController@getAuthUser');
    Route::get('departments','DepartmentController@index'); 
    Route::get('departments/{id}','DepartmentController@show'); 
    Route::post('departments','DepartmentController@store'); 
    Route::put('departments/{id}','DepartmentController@update'); 
    Route::delete('departments/{id}','DepartmentController@destroy');
});