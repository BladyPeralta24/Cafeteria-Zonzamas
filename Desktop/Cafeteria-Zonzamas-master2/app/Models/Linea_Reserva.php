<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Linea_Reserva extends Model
{
    use HasFactory;

    protected $table = 'linea_reserva';
    protected $primaryKey = 'id_linea';

    protected $fillable = [
        'id_linea',
        'id_reserva',
        'cantidad',
        'importe_linea',
        'id_producto',
    ];

    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'id_reserva', 'id_reserva');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto', 'id_producto');
    }
}
