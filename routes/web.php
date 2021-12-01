<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\ProveedorController;
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


//Cliente

Route::resource('clientes', ClienteController::class)->middleware('auth');

Route::get('clientes-search', [ClienteController::class, 'search'])->name('clientes.search')->middleware('auth');

Route::get('clientes-reporte', [ClienteController::class, 'export'])->name('clientes.reporte')->middleware('auth');



//Proveedor

Route::resource('proveedors', ProveedorController::class)->middleware('auth');

Route::get('proveedors-search', [ProveedorController::class, 'search'])->name('proveedors.search')->middleware('auth');

Route::get('proveedors-reporte', [ProveedorController::class, 'export'])->name('proveedors.reporte')->middleware('auth');