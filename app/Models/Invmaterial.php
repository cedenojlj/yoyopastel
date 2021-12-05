<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invmaterial extends Model
{
    use HasFactory;

    protected $fillable=['entrada','salida','material_id',
    'user_id','empresa_id'];


    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
