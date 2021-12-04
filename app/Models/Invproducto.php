<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invproducto extends Model
{
    use HasFactory;

    protected $fillable=['entrada','salida','producto_id',
    'user_id','empresa_id'];


    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
