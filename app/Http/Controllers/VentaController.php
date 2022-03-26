<?php

namespace App\Http\Controllers;

use App\Exports\VentaExport;
use App\Models\Caja;
use App\Models\Cliente;
use App\Models\Empleado;
use App\Models\Empresa;
use App\Models\Invproducto;
use App\Models\Pago;
use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;




class VentaController extends Controller
{

    public function index()
    {
        
        $id = auth()->user()->id;

        $idempresa = Empleado::where('user_id', $id)->first()->empresa_id; 

        $ventas = Venta::where('empresa_id', $idempresa)->orderBy('id','desc')->paginate(15);

        //$ventas = Venta::paginate(15);

        return view('ventas.index', compact('ventas'));
    }


    public function create()
    {
        return view('ventas.create');
    }


    public function show(Venta $venta)
    {


        $productos = DB::table('producto_venta')
            ->join('productos', 'producto_venta.producto_id', '=', 'productos.id')
            ->select('producto_venta.*', 'productos.nombre')
            ->where('producto_venta.venta_id', '=', $venta->id)
            ->get();

        $cliente = DB::table('ventas')
            ->join('clientes', 'ventas.cliente_id', '=', 'clientes.id')
            ->select('clientes.*')
            ->where('ventas.id', '=', $venta->id)
            ->first();


        return view('ventas.ver', compact('venta', 'productos', 'cliente'));
    }

    public function destroy(Venta $venta)
    {
        Invproducto::where('idVenta', $venta->id)->delete();

        $venta->delete();

        return redirect()->route('ventas.index')->with('success', 'Venta borrada con exito');
    }

    public function search(Request $request)
    {

        //dd($request);

        if ($request->search) {

            //return 'con valor';

            $busqueda = $request->search;

            $ventas = Venta::where(function ($query) {
                $query->select('nombre')
                    ->from('clientes')
                    ->whereColumn('clientes.id', 'ventas.cliente_id')
                    ->limit(1);
            }, 'like', '%' . $busqueda . '%')
                ->orWhere('factura', 'LIKE', '%' . $busqueda . '%')
                ->orWhere('fecha', 'LIKE', '%' . $busqueda . '%')
                ->paginate(15)->withQueryString();


            return view('ventas.index', compact('ventas'));
        } else {

            //return 'sin valor';

            return redirect()->route('ventas.index');
        }
    }

    public function export()
    {
        return Excel::download(new VentaExport, 'ventas.xlsx');
    }

    public function gestion()
    {

        $id = auth()->user()->id;

        $idempresa = Empleado::where('user_id', $id)->first()->empresa_id;

        //dd($idempresa);

        $anio = date('Y');

        //$ventas = Venta::where('empresa_id',$idempresa)->whereYear('fecha',$anio)->get();
        $nombre = Empresa::where('id', $idempresa)->value('nombre');
        $ventas = Venta::where('empresa_id', $idempresa)->whereYear('created_at', $anio)->sum('subtotal');
        $costos = Venta::where('empresa_id', $idempresa)->whereYear('created_at', $anio)->sum('subcosto');
        $pagos = Pago::where('empresa_id', $idempresa)->whereYear('created_at', $anio)->sum('pago');
        $total = $ventas - $costos - $pagos;


        $pdf = PDF::loadView('ventas.gestion', compact('ventas', 'costos', 'pagos', 'total', 'nombre'))->setOptions(['defaultFont' => 'sans-serif']);
        //$pdf->loadHTML('<h1>Test</h1>');
        //return $pdf->download('invoice.pdf');
        return $pdf->stream();
    }

    public function crearEmpresarial()
    {
        $empresas = Empresa::all();
        return view('ventas.empresarial', compact('empresas'));
    }

    public function reporteEmpresarial(Request $request)
    {

        $request->validate([

            'empresa_id' => 'required|numeric',
            'reporte_id' => 'required|numeric',
        ]);


        $id = auth()->user()->id;

        $idempresa = $request->empresa_id;

        $idreporte = $request->reporte_id;

        //dd($idempresa);

        $anio = date('Y');



        if ($idreporte == 1) {

            //$ventas = Venta::where('empresa_id',$idempresa)->whereYear('fecha',$anio)->get();
            $nombre = Empresa::where('id', $idempresa)->value('nombre');
            $ventas = Venta::where('empresa_id', $idempresa)->whereYear('created_at', $anio)->sum('subtotal');
            $costos = Venta::where('empresa_id', $idempresa)->whereYear('created_at', $anio)->sum('subcosto');
            $pagos = Pago::where('empresa_id', $idempresa)->whereYear('created_at', $anio)->sum('pago');
            $total = $ventas - $costos - $pagos;


            $pdf = PDF::loadView('ventas.gestion', compact('ventas', 'costos', 'pagos', 'total', 'nombre'))->setOptions(['defaultFont' => 'sans-serif']);             
            return $pdf->stream();
            //return $pdf->download('gestionempresa.pdf');

        }elseif ($idreporte == 2) {

            $nombre = Empresa::where('id', $idempresa)->value('nombre');

            $materials= DB::table('invmaterials') 
            ->join('materials','invmaterials.material_id','=','materials.id')                                
            ->select('invmaterials.material_id','materials.nombre as material', DB::raw('SUM(entrada) as entradas, SUM(salida) as salidas, (SUM(entrada) - SUM(salida)) as Stock'))
            ->where('invmaterials.empresa_id',$idempresa)
            ->whereYear('invmaterials.created_at',$anio)
            ->groupBy('invmaterials.material_id','materials.nombre')  
            ->get();  
                 
            $pdf = PDF::loadView('invmaterials.stock', compact('materials','nombre'))->setOptions(['defaultFont' => 'sans-serif']);            
            //return $pdf->download('invoice.pdf');
            return $pdf->stream();
            

        }elseif  ($idreporte == 3) {
            
            $nombre = Empresa::where('id', $idempresa)->value('nombre');
            $productos= DB::table('invproductos') 
            ->join('productos','invproductos.producto_id','=','productos.id')                                
            ->select('invproductos.producto_id','productos.nombre as producto', DB::raw('SUM(entrada) as entradas, SUM(salida) as salidas, (SUM(entrada) - SUM(salida)) as Stock'))
            ->where('invproductos.empresa_id',$idempresa)
            ->whereYear('invproductos.created_at',$anio)
            ->groupBy('invproductos.producto_id','productos.nombre')  
            ->get();          
    
                          
            $pdf = PDF::loadView('invproductos.stock', compact('productos','nombre'))->setOptions(['defaultFont' => 'sans-serif']);            
            //return $pdf->download('invoice.pdf');
            return $pdf->stream();

        }
    }

    public function crearCaja()
    {
        $empresas = Empresa::all();
        $empleados = Empleado::all();

        return view('ventas.crearcaja', compact('empresas', 'empleados'));
    }


    public function pdfCaja(Request $request)
    {

        $request->validate([

            'empresa_id' => 'required|numeric',
            'empleado_id' => 'required|numeric',
            'fecha' => 'required',
        ]);


        $id = $request->empleado_id;

        $idUser = Empleado::where('id', $id)->value('user_id');

        $nombre = Empleado::where('id', $id)->value('nombre');

        $apellido = Empleado::where('id', $id)->value('apellido');

        $empleado = $nombre . " " . $apellido;

        $idempresa = $request->empresa_id;

        $empresa = Empresa::where('id', $idempresa)->value('nombre');

        $fecha = $request->fecha;

        $bolivares = Caja::where('empresa_id', $idempresa)->whereDate('fecha', $fecha)
            ->where('user_id', $idUser)->where('moneda', 'Bs')
            ->selectRaw('metodo, SUM(total) as total')->groupBy('metodo')->get();

        //dd($bolivares);        

        $totalbolivares = Caja::where('empresa_id', $idempresa)->whereDate('fecha', $fecha)
            ->where('user_id', $idUser)->where('moneda', 'Bs')
            ->selectRaw('SUM(total) as totalbs')->first()->totalbs;

        //dd($totalbolivares);

        $dolares = Caja::where('empresa_id', $idempresa)->whereDate('fecha', $fecha)
            ->where('user_id', $idUser)->where('moneda', 'Usd')
            ->selectRaw('metodo, SUM(total) as total')->groupBy('metodo')->get();

        $totaldolares = Caja::where('empresa_id', $idempresa)->whereDate('fecha', $fecha)
            ->where('user_id', $idUser)->where('moneda', 'Usd')
            ->sum('total');


        $pdf = PDF::loadView('ventas.pdfcaja', compact('bolivares', 'totalbolivares', 'dolares', 'totaldolares', 'empleado', 'empresa', 'fecha'))
            ->setOptions(['defaultFont' => 'sans-serif']);

        //$pdf->loadHTML('<h1>Test</h1>');
        //return $pdf->download('invoice.pdf');
        return $pdf->stream();
        //return $pdf->download('caja.pdf');


    }

    public function factura(Venta $venta)
    {
        $cliente = Cliente::where('id', $venta->cliente_id)->first();

        $empresa = Empresa::where('id', $venta->empresa_id)->first();;

        $productos = DB::table('producto_venta')
            ->join('productos', 'producto_venta.producto_id', '=', 'productos.id')
            ->select('producto_venta.*', 'productos.nombre as producto')
            ->where('venta_id', $venta->id)->get();

      /*  $pdf = PDF::loadView('ventas.factura', compact('cliente', 'empresa', 'productos', 'venta'))
            ->setOptions(['defaultFont' => 'sans-serif']);  */

    /*    $pdf = PDF::loadView('ventas.ticket', compact('cliente', 'empresa', 'productos', 'venta'))
            ->setOptions(['defaultFont' => 'sans-serif',
                        'defaultPaperSize'=>'b7']);  */

        $pdf = PDF::loadView('ventas.ticket', compact('cliente', 'empresa', 'productos', 'venta'))
            ->setPaper(array(0,0,164.40,1000.00),'portrait')->setOptions(['defaultFont' => 'sans-serif']); 
        

        //$pdf->loadHTML('<h1>Test</h1>');
        //return $pdf->download('invoice.pdf');
        return $pdf->stream();
    }
}
