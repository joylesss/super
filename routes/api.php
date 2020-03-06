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

Route::group(['namespace' => 'Auth'], function () {
    Route::post('login', 'AuthController@login');
});/*
Route::group(['middleware' => 'auth', 'namespace' => 'Auth'], function () {

    Route::post('logout', 'AuthController@logout');
    Route::get('me', 'AuthController@me');

});
Route::get('info_app/{app_id}/{fb_id}', 'RequestController@infoApp')->where(['app_id' => '[0-9]', 'fb_id' => '[0-9]']);
Route::get('info_question/{app_id}/{fb_id}', 'RequestController@infoQuestion');*/

Route::middleware('auth')->group(function() {

    # Folder Auth
    Route::namespace('Auth')->group(function() {
        Route::get('me', 'AuthController@me');
        Route::post('logout', 'AuthController@logout');
    });

    # Folder Api
    Route::namespace('Api')->group(function() {
        Route::get('info_app/{app_id}/{fb_id}', 'RequestController@infoApp');
        Route::get('info_question/{app_id}', 'RequestController@infoQuestion');
        Route::get('info_score/{app_id}', 'RequestController@infoScore');
        Route::get('info_result/{app_id}', 'RequestController@infoResult');
    });
});


# Use for all request current
Route::match(['get', 'post'], '/', function () {

});


