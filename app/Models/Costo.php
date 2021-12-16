<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Costo extends Model
{
    use HasFactory;

    protected $fillable=[

        'producto_id',
        'user_id',
        'empresa_id'
    ];

    public function Producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function Materials()
    {
        return $this->belongsToMany(Material::class,'costo_material');
    }
}
