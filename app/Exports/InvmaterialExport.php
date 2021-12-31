<?php

namespace App\Exports;

use App\Models\Invmaterial;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class InvmaterialExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function headings(): array
    {
        return [

            'id',
            'Material',
            'Entrada',
            'Salida',            
            'user',
            'empresa',
            'Creado',
            'Actualizado',            
        ];
    }


    public function collection()
    {
        $reporte= DB::table('invmaterials')                            
        ->join('users','users.id','=','invmaterials.user_id')
        ->join('materials','invmaterials.material_id','=','materials.id')
        ->join('empresas','invmaterials.empresa_id','=','empresas.id')                             
        ->select('invmaterials.id','materials.nombre as material','invmaterials.entrada',
        'invmaterials.salida','users.name as user',
        'empresas.nombre as empresa','invmaterials.created_at as creado',
        'invmaterials.updated_at as actualizado')        
        ->orderBy('invmaterials.id','asc')
        ->get(); 

        return $reporte;   
    }
}
