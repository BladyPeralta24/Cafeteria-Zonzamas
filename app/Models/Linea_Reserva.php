<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Linea_Reserva extends Model
{
    use HasFactory;

    protected $table = 'linea_reserva';

    protected $fillable = [
        'id_linea',
        'id_reserva',
        'cantidad',
        'importe_linea',
        'id_producto',
    ];
}
