<?php

namespace App\Http\Controllers;

use App\Exports\ProveedorExport;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $proveedors = Proveedor::paginate(15);

        return view('proveedors.index', compact('proveedors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('proveedors.create');
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

            'nombre' => 'required|max:255',
            'rif' => 'required|max:255',
            'direccion' => 'required|max:255',
            'telefono' => 'required|max:255',
            'email' => 'required',
        ]);


        Proveedor::create($request->all());

        return redirect()->route('proveedors.index')->with('success', 'Proveedor Creada con Exito.');




    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function show(Proveedor $proveedor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function edit(Proveedor $proveedor)
    {
        return view('proveedors.edit', compact('proveedor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proveedor $proveedor)
    {
        $request->validate([

            'nombre' => 'required|max:255',
            'rif' => 'required|max:255',
            'direccion' => 'required|max:255',
            'telefono' => 'required|max:255',
            'email' => 'required',
        ]);

        $proveedor->update($request->all());

        return redirect()->route('proveedors.index')->with('success', 'proveedor Actualizada con Exito.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proveedor $proveedor)
    {
        
        $proveedor->delete();

        return redirect()->route('proveedors.index')->with('success', 'proveedor Borrada con Exito.');
    }

    public function search(Request $request)
    {
        
        //dd($request);

        if ($request->search) {

            //return 'con valor';

            $busqueda= $request->search;
            
            $proveedors= Proveedor::where('nombre','LIKE','%'.$busqueda.'%')
                            ->orWhere('rif','LIKE','%'.$busqueda.'%')
                            ->orWhere('email','LIKE','%'.$busqueda.'%')
                            ->paginate(15)->withQueryString(); 
                            
            return view('proveedors.index', compact('proveedors'));  

        } else {

            //return 'sin valor';

            return redirect()->route('proveedors.index');
        } 

                
    }

    public function export() 
    {
        return Excel::download(new ProveedorExport, 'proveedor.xlsx');
    }

}
