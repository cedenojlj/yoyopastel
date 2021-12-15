<?php

namespace App\Exports;

use App\Models\Invproducto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class InvproductoExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function headings(): array
    {
        return [

            'id',
            'Producto',
            'Entrada',
            'Salida',
            'idVenta',
            'user',
            'empresa',
            'Creado',
            'Actualizado',            
        ];
    }

    public function collection()
    {
                
         $reporte= DB::table('invproductos')                            
        ->join('users','users.id','=','invproductos.user_id')
        ->join('productos','invproductos.producto_id','=','productos.id')
        ->join('empresas','invproductos.empresa_id','=','empresas.id')                             
        ->select('invproductos.id','productos.nombre as producto','invproductos.entrada',
        'invproductos.salida','users.name as user',
        'empresas.nombre as empresa','invproductos.created_at as creado',
        'invproductos.updated_at as actualizado')        
        ->orderBy('invproductos.id','asc')
        ->get(); 

        return $reporte;        
       
    }
}
