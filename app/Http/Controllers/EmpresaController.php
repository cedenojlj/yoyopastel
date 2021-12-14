<?php

namespace App\Http\Controllers;

use App\Exports\EmpresaExport;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {

        $empresas = Empresa::paginate(15);

        return view('empresas.index', compact('empresas'));

        //return 'hola empresas';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('empresas.create');
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

        
        Empresa::create([
            
            'nombre' => $request->nombre,
            'rif' => $request->rif,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'factura'=> 0
        ]);

        return redirect()->route('empresas.index')->with('success', 'Empresa Creada con Exito.');

        //return $request;

    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function show(Empresa $empresa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function edit(Empresa $empresa)
    {

        return view('empresas.edit', compact('empresa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Empresa $empresa)
    {
        //
        $request->validate([

            'nombre' => 'required|max:255',
            'rif' => 'required|max:255',
            'direccion' => 'required|max:255',
            'telefono' => 'required|max:255',
            'email' => 'required',
        ]);

        $empresa->update([
            
            'nombre' => $request->nombre,
            'rif' => $request->rif,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'email' => $request->email,            
        ]);

        return redirect()->route('empresas.index')->with('success', 'Empresa Actualizada con Exito.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Empresa $empresa)
    {
        $empresa->delete();

        return redirect()->route('empresas.index')->with('success', 'Empresa Borrada con Exito.');
    }


    public function search(Request $request)
    {
        
        //dd($request);

        if ($request->search) {

            //return 'con valor';

            $busqueda= $request->search;
            
            $empresas= Empresa::where('nombre','LIKE','%'.$busqueda.'%')
                            ->orWhere('rif','LIKE','%'.$busqueda.'%')
                            ->orWhere('email','LIKE','%'.$busqueda.'%')
                            ->paginate(15)->withQueryString(); 
                            
            return view('empresas.index', compact('empresas'));  

        } else {

            //return 'sin valor';

            return redirect()->route('empresas.index');
        } 

                
    }

    public function export() 
    {
        return Excel::download(new EmpresaExport, 'empresa.xlsx');
    }

    
    
}
