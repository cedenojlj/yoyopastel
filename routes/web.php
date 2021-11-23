<?php

use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\EmpresaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// Empresa

Route::resource('empresas', EmpresaController::class)->middleware('auth');

Route::get('empresas-search', [EmpresaController::class, 'search'])->name('empresas.search')->middleware('auth');

Route::get('empresas-reporte', [EmpresaController::class, 'export'])->name('empresas.reporte')->middleware('auth');

//Empleado

Route::resource('empleados', EmpleadoController::class)->middleware('auth');

Route::get('empleados-search', [EmpleadoController::class, 'search'])->name('empleados.search')->middleware('auth');

Route::get('empleados-reporte', [EmpleadoController::class, 'export'])->name('empleados.reporte')->middleware('auth');

