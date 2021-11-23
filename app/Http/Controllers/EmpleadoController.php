<?php

namespace App\Http\Controllers;

use App\Exports\EmpleadoExport;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;



class EmpleadoController extends Controller
{
    
   
    public function index()
    {

        $empleados = Empleado::paginate(15);

        return view('empleados.index', compact('empleados'));

        //return 'hola empleados';
    }

   

    public function create()
    {
        return view('empleados.create');
    }

    

    public function store(Request $request)
    {
        $request->validate([

            'nombre' => 'required|max:255',
            'apellido' => 'required|max:255',
            'cedula' => 'required|max:255',
            'direccion' => 'required|max:255',
            'telefono' => 'required|max:255',
            'email' => 'required|email',
            'salario' => 'required|numeric',
            'foto' => 'required|file|image|max:1024',
            'empresa_id' => 'required|numeric',
        ]);

        /*   Empleado::create([
            
            'nombre' => $request->nombre,
            'rif' => $request->rif,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'email' => $request->email,
        ]); */

        Empleado::create($request->all());

        return redirect()->route('empleados.index')->with('success', 'Empresa Creada con Exito.');

        //return $request;

    }
   

   
    public function edit(Empleado $empleado)
    {

        return view('empleados.edit', compact('empresa'));
    }

   
    public function update(Request $request, Empleado $empleado)
    {
        //
        $request->validate([

            'nombre' => 'required|max:255',
            'apellido' => 'required|max:255',
            'cedula' => 'required|max:255',
            'direccion' => 'required|max:255',
            'telefono' => 'required|max:255',
            'email' => 'required|email',
            'salario' => 'required|numeric',
            'foto' => 'file|image|max:1024',
            'empresa_id' => 'required|numeric',
        ]);

        $empleado->update($request->all());

        return redirect()->route('empleados.index')->with('success', 'Empresa Actualizada con Exito.');
    }

    
    public function destroy(Empleado $empleado)
    {
        $empleado->delete();

        return redirect()->route('empleados.index')->with('success', 'Empresa Borrada con Exito.');
    }


    public function search(Request $request)
    {
        
        //dd($request);

        if ($request->search) {

            //return 'con valor';

            $busqueda= $request->search;
            
            $empleados= Empleado::where('nombre','LIKE','%'.$busqueda.'%')
                            ->orWhere('rif','LIKE','%'.$busqueda.'%')
                            ->orWhere('email','LIKE','%'.$busqueda.'%')
                            ->paginate(15)->withQueryString(); 
                            
            return view('empleados.index', compact('empleados'));  

        } else {

            //return 'sin valor';

            return redirect()->route('empleados.index');
        } 

                
    }

    public function export() 
    {
        return Excel::download(new EmpleadoExport, 'empleado.xlsx');
    }
}
