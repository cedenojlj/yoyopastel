<?php

namespace App\Exports;

use App\Models\Compra;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;



class CompraExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function headings(): array
    {
        return [

            'id',
            'fecha',
            'factura',
            'subtotal',
            'iva',
            'total',
            'proveedor_id',
            'user_id',            
            'Empresa_id',
            'Creado',
            'Actualizado',
            'proveedor',
            'usuario',
            'empresa'
            
        ];
    }

    public function collection()
    {
        return DB::table('compras')
        ->join('proveedors','compras.proveedor_id','=','proveedors.id')
        ->join('users','compras.user_id','=','users.id')
        ->join('empresas','compras.empresa_id','=','empresas.id')
        ->select('compras.*','proveedors.nombre as Proveed','users.name as Usuario','empresas.nombre as empresa')
        ->get();
    }
}
