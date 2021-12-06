<?php

namespace App\Http\Controllers;

use App\Exports\PagoExport;
use App\Models\Pago;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class PagoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pagos = Pago::paginate(15);

        return view('pagos.index', compact('pagos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pagos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([

            'pago' => 'required|numeric|min:0.1',
            'referencia' => 'required|max:255',
            'concepto' => 'required|max:255',

        ]);

        Pago::create($request->all());

        return redirect()->route('pagos.index')->with('success', 'Pago Creado con Exito.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pago  $pago
     * @return \Illuminate\Http\Response
     */
    public function show(Pago $pago)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pago  $pago
     * @return \Illuminate\Http\Response
     */
    public function edit(Pago $pago)
    {
        return view('pagos.edit', compact('pago'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pago  $pago
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pago $pago)
    {
        $request->validate([

            'pago' => 'required|numeric|min:0.1',
            'referencia' => 'required|max:255',
            'concepto' => 'required|max:255',

        ]);
        
        $pago->update($request->all());

        return redirect()->route('pagos.index')->with('success', 'Pago Actualizado con Exito.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pago  $pago
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pago $pago)
    {
        $pago->delete();

        return redirect()->route('pagos.index')->with('success', 'Pago Borrado con Exito.');
    }

    public function search(Request $request)
    {

        //dd($request);

        if ($request->search) {

            //return 'con valor';  
            
            $busqueda = $request->search;

            $pagos = Pago::where('referencia', 'LIKE', '%' . $busqueda . '%')
            ->orWhere('concepto', 'LIKE', '%' . $busqueda . '%')                
            ->paginate(15)->withQueryString();

            return view('pagos.index', compact('pagos'));

        } elseif ($request->inicio and $request->fin) {

            //return 'con valor';
            

            $pagos = Pago::where('created_at','>=',$request->inicio)
                ->where('created_at','<=',$request->fin)
                ->paginate(15)->withQueryString();

            return view('pagos.index', compact('pagos'));

        } else {

            //return 'sin valor';

            return redirect()->route('pagos.index');
        }

        
    }

    public function export()
    {
        return Excel::download(new PagoExport, 'pagos.xlsx');
    }
}
