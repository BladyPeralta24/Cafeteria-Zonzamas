<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Reserva extends Model
{
    use HasFactory;

    public const PENDIENTE = 'pendiente';
    public const PREPARADA = 'preparada';
    public const RECOGIDA = 'recogida';
    public const CANCELADA = 'cancelada';

    protected $table = 'reserva';
    protected $primaryKey = 'id_reserva';

    protected $fillable = [
        'id_reserva',
        'fecha_reserva',
        'hora_recogida',
        'estado',
        'impuesto_IGIC',
        'subtotal',
        'descuento_total',
        'total',
        'id_cliente',
        'id_empleado',
    ];

    protected $casts = [
        'fecha_reserva' => 'date',
    ];

    public function cliente()
    {
        return $this->belongsTo(User::class, 'id_cliente', 'id');
    }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'id_empleado', 'id_empleado');
    }

    public function lineas()
    {
        return $this->hasMany(Linea_Reserva::class, 'id_reserva', 'id_reserva');
    }

    /** Hora de recogida en formato HH:MM (la columna guarda HH:MM:SS). */
    public function getHoraAttribute(): string
    {
        return substr((string) $this->hora_recogida, 0, 5);
    }

    public function estaActiva(): bool
    {
        return in_array($this->estado, [self::PENDIENTE, self::PREPARADA], true);
    }

    /**
     * Cancela la reserva y devuelve el stock de sus productos.
     */
    public function cancelar(): void
    {
        DB::transaction(function () {
            $actual = static::whereKey($this->getKey())->lockForUpdate()->first();

            if (! $actual || ! $actual->estaActiva()) {
                return;
            }

            foreach ($actual->lineas as $linea) {
                Producto::where('id_producto', $linea->id_producto)
                    ->increment('stock', $linea->cantidad);
            }

            $actual->estado = self::CANCELADA;
            $actual->save();
        });

        $this->refresh();
    }
}
