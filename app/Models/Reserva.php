<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    protected $table = 'reserva';

    protected $fillable = [
        'id_reserva',
        'fecha_reserva',
        'impuesto_IGIC',
        'subtotal',
        'descuento_total',
        'total',
        'id_cliente',
        'id_empleado',
    ];
}
