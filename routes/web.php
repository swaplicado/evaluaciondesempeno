<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();
Route::group(['middleware' => ['auth']], function() {
    Route::get('/home', 'HomeController@index')->name('home');

/* Objetivos */
    
    Route::get('objetive', 'ObjetiveController@index')->name('objetivo');
    Route::get('objetive/create/{id}', 'ObjetiveController@create')->name('crear_objetivo');
    Route::post('objetive', 'ObjetiveController@store')->name('guardar_objetivo');
    Route::get('objetive/{id}/edit', 'ObjetiveController@edit')->name('editar_objetivo');
    Route::put('objetive/{id}', 'ObjetiveController@update')->name('actualizar_objetivo');
    Route::delete('objetive/{id}', 'ObjetiveController@destroy')->name('eliminar_objetivo');
    Route::post('objetive/guardar', 'ObjetiveController@send_to_aprove')->name('enviar_objetivo');

/* Tutorial */

    Route::get('tutorial', 'TutorialController@index')->name('tutorial');
});