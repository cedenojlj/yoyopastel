<?php

namespace App\Exports;

use App\Models\Costo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class CostoExport implements FromCollection, WithHeadings
{
    
    public function headings(): array
    {
        return [

            'id',
            'Producto',            
            'user',
            'empresa',
            'Creado',
            'Actualizado',            
        ];
    }


    public function collection()
    {
        $reporte= DB::table('costos')                            
        ->join('users','users.id','=','costos.user_id')
        ->join('productos','costos.producto_id','=','productos.id')
        ->join('empresas','costos.empresa_id','=','empresas.id')                             
        ->select('costos.id','productos.nombre as producto','users.name as user',
        'empresas.nombre as empresa','costos.created_at as creado',
        'costos.updated_at as actualizado')        
        ->orderBy('costos.id','asc')
        ->get(); 

        return $reporte;      
    }
}
