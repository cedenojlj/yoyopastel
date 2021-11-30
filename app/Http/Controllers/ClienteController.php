<?php

namespace App\Http\Controllers;

use App\Exports\ClienteExport;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class ClienteController extends Controller
{
    
    public function index()
    {

        $clientes = Cliente::paginate(15);

        return view('clientes.index', compact('clientes'));

        //return 'hola clientes';
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        $request->validate([

            'nombre' => 'required|max:255',
            'rif' => 'required|max:255',
            'direccion' => 'required|max:255',
            'telefono' => 'required|max:255',
            'email' => 'required',
        ]);

        /*   Cliente::create([
            
            'nombre' => $request->nombre,
            'rif' => $request->rif,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'email' => $request->email,
        ]); */

        Cliente::create($request->all());

        return redirect()->route('clientes.index')->with('success', 'Cliente Creado con Exito.');

        //return $request;

    }

    public function edit(Cliente $cliente)
    {

        return view('clientes.edit', compact('cliente'));
    }


    public function update(Request $request, Cliente $cliente)
    {
        //
        $request->validate([

            'nombre' => 'required|max:255',
            'rif' => 'required|max:255',
            'direccion' => 'required|max:255',
            'telefono' => 'required|max:255',
            'email' => 'required',
        ]);

        $cliente->update($request->all());

        return redirect()->route('clientes.index')->with('success', 'Cliente Actualizado con Exito.');
    }


    public function destroy(Cliente $cliente)
    {
        $cliente->delete();

        return redirect()->route('clientes.index')->with('success', 'Cliente Borrado con Exito.');
    }


    
    public function search(Request $request)
    {
        
        //dd($request);

        if ($request->search) {

            //return 'con valor';

            $busqueda= $request->search;
            
            $clientes= Cliente::where('nombre','LIKE','%'.$busqueda.'%')
                            ->orWhere('rif','LIKE','%'.$busqueda.'%')
                            ->orWhere('email','LIKE','%'.$busqueda.'%')
                            ->paginate(15)->withQueryString(); 
                            
            return view('clientes.index', compact('clientes'));  

        } else {

            //return 'sin valor';

            return redirect()->route('clientes.index');
        } 

                
    }

    public function export() 
    {
        return Excel::download(new ClienteExport, 'cliente.xlsx');
    }

    


}
