<?php

namespace App\Http\Controllers;

use App\Exports\CategoriaExport;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        $categorias = Categoria::paginate(15);

        return view('categorias.index', compact('categorias'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categorias.create');
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

            'nombre' => 'required|max:255'
                        
        ]);

        /*   Categoria::create([
            
            'nombre' => $request->nombre,
            'rif' => $request->rif,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'email' => $request->email,
        ]); */

        Categoria::create($request->all());

        return redirect()->route('categorias.index')->with('success', 'Categoria Creada con Exito.');

        //return $request;

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function show(Categoria $categoria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function edit(Categoria $categoria)
    {
        
        return view('categorias.edit', compact('categoria'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Categoria $categoria)
    {
        $request->validate([

            'nombre' => 'required|max:255'            
        ]);

        $categoria->update($request->all());

        return redirect()->route('categorias.index')->with('success', 'Categoria Actualizada con Exito.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categoria $categoria)
    {
        $categoria->delete();

        return redirect()->route('categorias.index')->with('success', 'Categoria Borrada con Exito.');

    }

    public function search(Request $request)
    {
        
        //dd($request);

        if ($request->search) {

            //return 'con valor';

            $busqueda= $request->search;
            
            $categorias= Categoria::where('nombre','LIKE','%'.$busqueda.'%')                            
                            ->paginate(15)->withQueryString(); 
                            
            return view('categorias.index', compact('categorias'));  

        } else {

            //return 'sin valor';

            return redirect()->route('categorias.index');
        } 

                
    }

    public function export() 
    {
        return Excel::download(new CategoriaExport, 'categorias.xlsx');
    }
}
