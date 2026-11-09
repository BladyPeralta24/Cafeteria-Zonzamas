<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    /**
     * "Mis reservas": historial del cliente.
     */
    public function index(Request $request)
    {
        $reservas = Reserva::with('lineas.producto')
            ->where('id_cliente', $request->user()->id)
            ->orderByDesc('id_reserva')
            ->get();

        return view('reservas.index', ['reservas' => $reservas]);
    }

    /**
     * El cliente cancela una reserva suya que aún está pendiente.
     */
    public function cancelar(Request $request, Reserva $reserva)
    {
        abort_unless((int) $reserva->id_cliente === (int) $request->user()->id, 403);

        if ($reserva->estado !== Reserva::PENDIENTE) {
            return back()->with('error', 'Solo se pueden cancelar reservas pendientes.');
        }

        $reserva->cancelar();

        return back()->with('success', "Reserva #{$reserva->id_reserva} cancelada.");
    }
}
