<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\CostoController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\InvmaterialController;
use App\Http\Controllers\InvproductoController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\ParidadController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\VentaController;






use App\Models\Empleado;
use App\Models\Empresa;
use App\Models\Invproducto;
use App\Models\Producto;
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


//compras

Route::resource('compras', CompraController::class)->middleware('auth');

Route::get('compras-search', [CompraController::class, 'search'])->name('compras.search')->middleware('auth');

Route::get('compras-reporte', [CompraController::class, 'export'])->name('compras.reporte')->middleware('auth');


//ventas

Route::resource('ventas', VentaController::class)->middleware('auth');

Route::get('ventas-search', [VentaController::class, 'search'])->name('ventas.search')->middleware('auth');

Route::get('ventas-reporte', [VentaController::class, 'export'])->name('ventas.reporte')->middleware('auth');


//costo de fabricacion de los productos

Route::resource('costos', CostoController::class)->middleware('auth');

Route::get('costos-search', [CostoController::class, 'search'])->name('costos.search')->middleware('auth');

Route::get('costos-reporte', [CostoController::class, 'export'])->name('costos.reporte')->middleware('auth');


//Para los reportes de gestion y otros

Route::get('ventas-gestion', [VentaController::class, 'gestion'])->name('ventas.gestion')->middleware('auth');

Route::get('ventas-empresarial', [VentaController::class, 'crearEmpresarial'])->name('ventas.empresarial')->middleware('auth');

Route::post('ventas-pdfempresarial', [VentaController::class, 'reporteEmpresarial'])->name('ventas.pdfempresarial')->middleware('auth');

Route::get('ventas-pdfstockproducto', [InvproductoController::class, 'pdfStockProducto'])->name('ventas.pdfStockProducto')->middleware('auth');

Route::get('ventas-pdfstockmaterial', [InvmaterialController::class, 'pdfStockMaterial'])->name('ventas.pdfStockMaterial')->middleware('auth');

Route::get('ventas-crearcaja', [VentaController::class, 'crearCaja'])->name('ventas.crearCaja')->middleware('auth');

Route::post('ventas-pfdcaja', [VentaController::class, 'pdfCaja'])->name('ventas.pdfCaja')->middleware('auth');

Route::get('ventas/{venta}/factura', [VentaController::class, 'factura'])->name('ventas.factura')->middleware('auth');



///prueba

Route::get('/pruebas', function () {

     $id = auth()->user()->id;

        $idempresa = Empleado::where('user_id', $id)->first()->empresa_id;

        $nombre=Empresa::where('id',$idempresa)->value('nombre');   

        //dd($idempresa);

        $anio= date('Y'); 
        $idproducto=1;
                
        $productos= DB::table('invproductos') 
        ->join('productos','invproductos.producto_id','=','productos.id')                                
        ->select(DB::raw('SUM(entrada) as entradas, SUM(salida) as salidas, (SUM(entrada) - SUM(salida)) as Stock'))
        ->where('invproductos.empresa_id',$idempresa)
        ->where('invproductos.producto_id',$idproducto)
        ->whereYear('invproductos.created_at',$anio)        
        ->first()->Stock; 
        
        dd($productos);
        
});
