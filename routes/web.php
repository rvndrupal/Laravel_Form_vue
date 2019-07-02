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
    return view('welcome');
});

Route::get('/index', function () {
    return view('index');
});

Route::get('/categoria', 'CategoriasController@index');
Route::post('/categoria/registrar', 'CategoriasController@store');
Route::put('/categoria/actualizar', 'CategoriasController@update');
Route::put('/categoria/desactivar', 'CategoriasController@desactivar');
Route::put('/categoria/activar', 'CategoriasController@activar');
Route::get('/categoria/listarPdf','CategoriasController@listarPdf')->name('categorias_pdf');
