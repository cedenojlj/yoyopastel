<?php

namespace App\Exports;

use App\Models\Producto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductoExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public function headings(): array
    {
        return [

            'id',
            'codigo',
            'nombre',
            'descripcion',
            'precio',
            'costo',
            'ganancia',
            'stock',
            'stock_min',            
            'Creado',
            'Actualizado',
            'categoria_id',
        ];
    }


    public function collection()
    {
        return Producto::all();
    }
}
