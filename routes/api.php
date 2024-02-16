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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::post('login', 'api\\AuthController@login');

Route::group(['middleware' => 'auth:api'], function() {
    Route::post('getUserToGlobalUser', [
        'uses' => 'api\\apiGlobalUsersController@getUserToGlobalUser'
    ]);

    Route::post('getListUsers', [
        'uses' => 'api\\apiGlobalUsersController@getListUsersToGlobalUsers'
    ]);

    Route::get('getUserById/{id}', [
        'uses' => 'api\\apiGlobalUsersController@getUserById'
    ]);

    Route::post('updateGlobal',[
        'uses' => 'api\\apiGlobalUsersController@update_global'
    ]);
});