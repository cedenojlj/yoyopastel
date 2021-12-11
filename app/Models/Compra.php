<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    protected $fillable=[

        'fecha',
        'factura',
        'subtotal',
        'iva',
        'total',
        'proveedor_id',
        'user_id',
        'empresa_id'
    ];


    public function materials()
    {
        return $this->belongsToMany(Material::class,'compra_material');
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }
}
