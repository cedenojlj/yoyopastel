<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $fillable=[

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
        'empresa_id'
    ];

    public function productos()
    {
        return $this->belongsToMany(Producto::class,'producto_venta');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
