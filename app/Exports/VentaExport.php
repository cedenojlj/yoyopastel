<?php

namespace App\Exports;

use App\Models\Venta;
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
            'Actualizado'
        ];
    }

    public function collection()
    {
        return Venta::all();
    }
}
