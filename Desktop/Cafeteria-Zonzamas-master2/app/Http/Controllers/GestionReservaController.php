<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Reserva;
use Illuminate\Http\Request;

/**
 * Panel para el personal de la cafetería (admin y empleados).
 */
class GestionReservaController extends Controller
{
    /** Estados a los que se puede pasar desde cada estado. */
    private const TRANSICIONES = [
        Reserva::PENDIENTE => [Reserva::PREPARADA, Reserva::CANCELADA],
        Reserva::PREPARADA => [Reserva::RECOGIDA, Reserva::CANCELADA],
    ];

    public function index(Request $request)
    {
        $this->soloPersonal($request);

        $fecha = $request->query('fecha', today()->toDateString());
        $verTodas = $request->boolean('todas');

        $reservas = Reserva::with(['cliente', 'lineas.producto'])
            ->whereDate('fecha_reserva', $fecha)
            ->when(! $verTodas, fn ($q) => $q->whereIn('estado', [Reserva::PENDIENTE, Reserva::PREPARADA]))
            ->orderBy('hora_recogida')
            ->get();

        return view('gestion.reservas', [
            'reservas' => $reservas,
            'fecha' => $fecha,
            'verTodas' => $verTodas,
        ]);
    }

    public function update(Request $request, Reserva $reserva)
    {
        $this->soloPersonal($request);

        $datos = $request->validate([
            'estado' => ['required', 'in:preparada,recogida,cancelada'],
        ]);

        $permitidos = self::TRANSICIONES[$reserva->estado] ?? [];

        if (! in_array($datos['estado'], $permitidos, true)) {
            return back()->with('error', "La reserva #{$reserva->id_reserva} no puede pasar de «{$reserva->estado}» a «{$datos['estado']}».");
        }

        if ($datos['estado'] === Reserva::CANCELADA) {
            $reserva->cancelar();
        } else {
            $reserva->estado = $datos['estado'];

            // Solo se asigna empleado si el usuario tiene ficha de empleado (el admin puede no tenerla).
            if (Empleado::whereKey($request->user()->id)->exists()) {
                $reserva->id_empleado = $request->user()->id;
            }

            $reserva->save();
        }

        return back()->with('success', "Reserva #{$reserva->id_reserva} marcada como «{$reserva->estado}».");
    }

    private function soloPersonal(Request $request): void
    {
        abort_unless($request->user()->esPersonal(), 403);
    }
}
