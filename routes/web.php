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
    // return view('auth.login');
    return redirect(route('login'));
});

Auth::routes();
Route::post('/login', 'Auth\LoginController@authenticate')->name('MyLogin');
Route::get('/logout', 'Auth\LoginController@logout')->name('MyLogout');
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

/* Contraseñas */

    Route::get('user/change', 'UserController@change')->name('cambio_usuario');
    Route::put('user/{id}/cambio', 'UserController@updatePassword')->name('actualizar_contraseña');

/* Objetivos jefes */

    Route::get('objetive/list/{id}', 'ObjetiveController@list_objetives')->name('listar_objetivos');
    Route::post('objetive/evalrefuse', 'ObjetiveController@refuse_evaluation')->name('evaluacion_rechazar');
    Route::post('objetive/evalaprove', 'ObjetiveController@aprove_score')->name('evaluacion_aprobar');
    //Route::post('objetive/calificar', 'ObjetiveController@hola')->name('calificarObjetivo'); 
    
/* Reportes */

    Route::get('report/control/{id}', 'ReportController@control_report')->name('reporte_control');
    Route::post('report/control/generar', 'ReportController@control_report_gen')->name('reporte_control_generar');
    Route::get('report/control/evaluadores/colaboradores', 'ReportController@evaluadores')->name('evaluadores');
    
/* Evaluadores */

    Route::get('assigntEval','assigntEvalController@index')->name('assignt_eval');
    Route::post('assigntEval/set','assigntEvalController@storage')->name('assignt_eval_save');

/* Crear año */

    Route::get('evalYears','evalYearsController@index')->name('evalYears');
    Route::post('evalYear/set','evalYearsController@store')->name('evalYear_save');
    Route::post('evalYear/status','evalYearsController@update')->name('evalYear_update');

/* Cambiar año */
    Route::post('changeYear', 'evalYearsController@change_year')->name('change_year');

/* Registrar usuarios */

    Route::get('/users/create', 'UserController@create')->name('crear_user');
    Route::post('/users/store', 'UserController@store')->name('guardar_user');

/* Fecha de cierre */

    Route::get('/closeDate', 'closeDate@index')->name('close_date');
    Route::post('/closeDate/edit', 'closeDate@store')->name('close_date_edit');
});