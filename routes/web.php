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
	$datos =1;
    return view('home1', compact('datos'));
});

Auth::routes();

Route::get('/cuenta', 'HomeController@index')->name('cuenta');

Route::get('/credito', 'HomeController@credito')->name('credito');

Route::post('/credito', 'HomeController@creditocrear')->name('crear');

///transacciones 
Route::get('/transferencia/{cuentadestino}/{cuentaorigen}/{monto}','transferencias@traspaso');


/// rutaa de tienda que tiene que armar la cadena
Route::get('/tienda/{cuentausuario}/{cuentatienda}/{monto}/{sitio}/{descripcion}', 'transferencias@tienda');

/// ruta del otro banco para buscar en mis base de datos
Route::get('/buscarusuario/{cuentausuario}/{tienda}/{monto}/{sitio}/{descripcion}', 'transferencias@buscar');
//url de Xoel /conexion_banco.phg?cuentau=///&monto=////&sitio=/////&desc=////

Route::get('/descargar-productos/{type}/{cuenta}', 'HomeController@export')->name('export.file');
Route::get('/import', 'HomeController@import')->name('export.file');

Route::get('/log', 'HomeController@exportlog')->name('exportlog.file');

Route::get('/imprimir/{numerocuenta}', 'transferencias@imprimir')->name('print');

Route::get('/pruebaslog', 'transferencias@log')->name('lo');
