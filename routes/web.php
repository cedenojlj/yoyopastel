<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\InvmaterialController;
use App\Http\Controllers\InvproductoController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\ParidadController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;



use App\Models\Empleado;
use App\Models\Empresa;
use App\Models\Invproducto;



use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;


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


//Categoria

Route::resource('categorias', CategoriaController::class)->middleware('auth');

Route::get('categorias-search', [CategoriaController::class, 'search'])->name('categorias.search')->middleware('auth');

Route::get('categorias-reporte', [CategoriaController::class, 'export'])->name('categorias.reporte')->middleware('auth');


//Producto

Route::resource('productos', ProductoController::class)->middleware('auth');

Route::get('productos-search', [ProductoController::class, 'search'])->name('productos.search')->middleware('auth');

Route::get('productos-reporte', [ProductoController::class, 'export'])->name('productos.reporte')->middleware('auth');

//

Route::get('/jose', function () {

    //$id=auth()->user()->id;
    //$jose=Empleado::where('user_id',$id)->first()->empresa_id;

    /* $jose = DB::table('invproductos')
    ->join('productos','invproductos.producto_id','=','productos.id')
    ->join('users','invproductos.user_id','=','users.id')
    ->join('empresas','invproductos.empresa_id','=','empresas.id')
    ->select('productos.nombre','invproductos.entrada',
             'invproductos.salida','users.name','empresas.nombre')->get();
 */
    /* $jose = DB::table('invproductos')                            
             ->join('users','users.id','=','invproductos.user_id')
             ->join('productos','invproductos.producto_id','=','productos.id')
             ->join('empresas','invproductos.empresa_id','=','empresas.id')                             
             ->select('productos.nombre as producto','invproductos.entrada','invproductos.salida','users.name as user','empresas.nombre as empresa')
             ->where('productos.nombre','like','%ton%')
             ->orderBy('invproductos.id','asc')
             ->get();*/

             /* $busqueda='';
             
    $jose =  DB::table('invproductos') 
             ->join('productos','invproductos.producto_id','=','productos.id')                                     
             ->select('invproductos.*')
             ->where('productos.nombre','like','%' . $busqueda . '%')
             ->paginate(15); */ 

             $busqueda='';

             /* $jose = Invproducto::where(function ($query) {
                $query->select('nombre')
                    ->from('productos')
                    ->whereColumn('productos.id', 'invproductos.producto_id')                    
                    ->limit(1);
            }, 'like','%' . $busqueda . '%')->get(); */

            $jose = Invproducto::where(function ($query) {
                $query->select('nombre')
                    ->from('productos')
                    ->whereColumn('productos.id', 'invproductos.producto_id')                    
                    ->limit(1);
            }, 'like','%' . $busqueda . '%')->paginate(15);

    //$jose = Invproducto::paginate(15);
    
    dd($jose);
});


//Inventario Producto

Route::resource('invproductos', InvproductoController::class)->middleware('auth');

Route::get('invproductos-search', [InvproductoController::class, 'search'])->name('invproductos.search')->middleware('auth');

Route::get('invproductos-reporte', [InvproductoController::class, 'export'])->name('invproductos.reporte')->middleware('auth');


//Materiales

Route::resource('materials', MaterialController::class)->middleware('auth');

Route::get('materials-search', [MaterialController::class, 'search'])->name('materials.search')->middleware('auth');

Route::get('materials-reporte', [MaterialController::class, 'export'])->name('materials.reporte')->middleware('auth');

//Tipo de Cambio

Route::resource('paridads', ParidadController::class)->middleware('auth');

Route::get('paridads-search', [ParidadController::class, 'search'])->name('paridads.search')->middleware('auth');

Route::get('paridads-reporte', [ParidadController::class, 'export'])->name('paridads.reporte')->middleware('auth');


//Inventario Metariales

Route::resource('invmaterials', InvmaterialController::class)->middleware('auth');

Route::get('invmaterials-search', [InvmaterialController::class, 'search'])->name('invmaterials.search')->middleware('auth');

Route::get('invmaterials-reporte', [InvmaterialController::class, 'export'])->name('invmaterials.reporte')->middleware('auth');


//Pagos

Route::resource('pagos', PagoController::class)->middleware('auth');

Route::get('pagos-search', [PagoController::class, 'search'])->name('pagos.search')->middleware('auth');

Route::get('pagos-reporte', [PagoController::class, 'export'])->name('pagos.reporte')->middleware('auth');
