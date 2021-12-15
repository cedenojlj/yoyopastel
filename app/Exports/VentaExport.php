<?php

namespace App\Exports;

use App\Models\Venta;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class VentaExport implements FromCollection, WithHeadings
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
            'paridad',
            'moneda',
            'metodo',
            'cliente_id',
            'user_id',
            'empresa_id',
            'Creado',
            'Actualizado',
            'cliente',
            'usuario',
            'empresa'
        ];
    }

    public function collection()
    {
        return DB::table('ventas')
               ->join('clientes','ventas.cliente_id','=','clientes.id')
               ->join('users','ventas.user_id','=','users.id')
               ->join('empresas','ventas.empresa_id','=','empresas.id')
               ->select('ventas.*','clientes.nombre as Client','users.name as Usuario','empresas.nombre as empresa')
               ->get();
    }
}
