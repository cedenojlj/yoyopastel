<?php

namespace App\Http\Controllers;

use App\Exports\VentaExport;
use App\Models\Cliente;
use App\Models\Empleado;
use App\Models\Invproducto;
use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDF;




class VentaController extends Controller
{
   
    public function index()
    {
        $ventas = Venta::paginate(15);

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

        $anio= date('Y');        
       
        //$ventas = Venta::where('empresa_id',$idempresa)->whereYear('fecha',$anio)->get();

        $ventas = Venta::where('empresa_id',$idempresa)->whereYear('fecha',$anio)->sum('subtotal');

       //return view('ventas.gestion',compact('ventas'));
        
        /*$pdf = PDF::loadView('ventas.gestion', $ventas);
        return $pdf->download('invoice.pdf');  */

        //$pdf = PDF::loadView('ventas.gestion', ['ventas'=>$ventas])->setOptions(['defaultFont' => 'sans-serif']);
        $pdf = PDF::loadView('ventas.modelo', ['ventas'=>$ventas])->setOptions(['defaultFont' => 'sans-serif']);
        //$pdf->loadHTML('<h1>Test</h1>');
        //return $pdf->download('invoice.pdf');
        return $pdf->stream();

        
    }
}
