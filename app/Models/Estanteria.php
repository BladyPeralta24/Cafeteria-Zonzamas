<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estanteria extends Model
{
    use HasFactory;

    protected $table = 'estanteria';

    protected $fillable = [
        'cod_estanteria',
        'cod_almacen',
        'capacidad',
        'dimensiones',
    ];
}
