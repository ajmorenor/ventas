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

// Genericas
// ***************************************************************************
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('logout', 'Auth\LoginController@logout');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('home.anno/{anno}', 'HomeController@indicadores')->name('home.anno');
Route::get('home.annos/{anno}', 'HomeController@indicadores')->name('home.annos');
Route::get('/indicadores', 'HomeController@indicadores')->name('indicadores');
Route::get('/indicadoresfuentes', 'HomeController@indicadoresfuentes')->name('indicadoresfuentes');
// ***************************************************************************

// Proyeccion
// ***************************************************************************
Route::get('proyeccion/{id}/agregar', 'ProyeccionController@add');
Route::get('proyeccion.delete', 'ProyeccionController@delete');
Route::get('/proyeccion', 'ProyeccionController@index'); 

Route::post('proyeccion/save', 'ProyeccionController@save'); 
// ***************************************************************************

// Empresas
// ***************************************************************************
Route::get('empresa.delete', 'EmpresaController@delete');
Route::get('empresa/{id}/edit', 'EmpresaController@edit');
Route::get('empresa/add', 'EmpresaController@add');
Route::post('empresa/{id}/update', 'EmpresaController@update');

// It is POST, since it comes from a form post
Route::post('empresa/save', 'EmpresaController@save'); 
// ***************************************************************************

// Fuentes
// ***************************************************************************
Route::get('/fuentev', 'FuenteController@index')->name('fuentev')->middleware('auth');

Route::get('fuente.delete', 'FuenteController@delete');
Route::get('fuente/{id}/edit', 'FuenteController@edit');
Route::get('fuente/add', 'FuenteController@add');
Route::post('fuente/{id}/update', 'FuenteController@update');

// It is POST, since it comes from a form post
Route::post('fuente/save', 'FuenteController@save'); 
// ***************************************************************************

// Metodos
// ***************************************************************************
Route::get('/metodov', 'MetodoController@index')->name('metodov')->middleware('auth');

Route::get('metodo.delete', 'MetodoController@delete');
Route::get('metodo/{id}/edit', 'MetodoController@edit');
Route::get('metodo/add', 'MetodoController@add');
Route::post('metodo/{id}/update', 'MetodoController@update');

// It is POST, since it comes from a form post
Route::post('metodo/save', 'MetodoController@save'); 
// ***************************************************************************

// Fuentes relacionadas a empresas
// ***************************************************************************

Route::get('relacion/{id}/index', 'RelacionController@index');
Route::get('relacion/{id}/{idempresa}/delete', 'RelacionController@delete');
Route::get('relacion/{id}/edit', 'RelacionController@edit');
Route::get('relacion/{id}/{mensaje}/add', 'RelacionController@add');
//Route::post('relacion/{id}/update', 'RelacionController@update');

// It is POST, since it comes from a form post
Route::post('relacion/save', 'RelacionController@save'); 
// ***************************************************************************

// Metodos - Fuentes relacionadas a empresas
// ***************************************************************************
Route::get('servicio/{idempresa}/index', 'ServicioController@index');
Route::get('servicio/{idservicio}/edit', 'ServicioController@edit');
Route::get('servicio/{idservicio}/agregar', 'ServicioController@agregar');
Route::get('servicio.delete', 'ServicioController@delete');
Route::get('servicio/{idempresa}/{mensaje}/add', 'ServicioController@add');
Route::get('busqueda/servicio', 'ServicioController@busqueda');
Route::get('servicio/todos', 'ServicioController@todos');
Route::get('/allservicios', 'ServicioController@allservices')->name('allservicios')->middleware('auth');
Route::get('servicio/bespecifica', 'ServicioController@bespecifica');

Route::post('servicio/update', 'ServicioController@update');
Route::post('servicio/busqueda', 'ServicioController@buscar');
Route::post('servicio/save', 'ServicioController@save'); 
// ***************************************************************************

// Email related routes
// ***************************************************************************
//Route::get('mail/send', 'MailController@send');
Route::get('mail/barra', 'MailController@barra');

Route::post('procesar', 'MailController@procesar');
// ***************************************************************************

// Excel
// ***************************************************************************
Route::get('verdes', 'ExcelController@verdes');
// ***************************************************************************


