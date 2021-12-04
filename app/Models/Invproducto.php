<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invproducto extends Model
{
    use HasFactory;

    protected $fillable=['entrada','salida','producto_id'];
}
