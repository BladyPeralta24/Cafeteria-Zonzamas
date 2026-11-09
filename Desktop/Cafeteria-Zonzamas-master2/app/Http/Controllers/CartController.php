<?php

namespace App\Http\Controllers;

use App\Exceptions\ReservaException;
use App\Models\Cart;
use App\Models\Linea_Reserva;
use App\Models\Producto;
use App\Models\Reserva;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Muestra "Mi reserva" (el carrito) del usuario.
     */
    public function index(Request $request)
    {
        $items = Cart::with('producto')
            ->where('id_user', $request->user()->id)
            ->orderBy('id')
            ->get();

        $total = round($items->sum(fn ($item) => $item->importe), 2);
        $rate = config('cafeteria.igic');
        $base = round($total / (1 + $rate / 100), 2);

        return view('cart.index', [
            'items' => $items,
            'total' => $total,
            'base' => $base,
            'igic' => round($total - $base, 2),
            'igicRate' => $rate,
            'apertura' => config('cafeteria.hora_apertura'),
            'cierre' => config('cafeteria.hora_cierre'),
            'maxUnidades' => config('cafeteria.max_unidades_por_producto'),
        ]);
    }

    /**
     * Añade un producto al carrito (la llama el modal de la carta por AJAX).
     */
    public function addToCart(Request $request)
    {
        $max = config('cafeteria.max_unidades_por_producto');

        $datos = $request->validate([
            'id_producto' => ['required', 'integer', 'exists:producto,id_producto'],
            'cantidad' => ['required', 'integer', 'min:1', 'max:'.$max],
        ]);

        // El usuario sale de la sesión, nunca del formulario.
        $user = $request->user();
        $producto = Producto::findOrFail($datos['id_producto']);

        $item = Cart::firstOrNew([
            'id_user' => $user->id,
            'id_producto' => $producto->id_producto,
        ]);

        $nueva = ($item->exists ? $item->cantidad : 0) + $datos['cantidad'];

        if ($producto->stock < 1) {
            return response()->json(['success' => false, 'message' => "«{$producto->nombre}» está agotado."], 422);
        }

        if ($nueva > $producto->stock) {
            return response()->json([
                'success' => false,
                'message' => "Solo quedan {$producto->stock} unidades de «{$producto->nombre}».",
            ], 422);
        }

        if ($nueva > $max) {
            return response()->json([
                'success' => false,
                'message' => "Máximo {$max} unidades de cada producto por reserva.",
            ], 422);
        }

        $item->cantidad = $nueva;
        $item->save();

        return response()->json([
            'success' => true,
            'message' => "«{$producto->nombre}» añadido a tu reserva.",
            'count' => (int) Cart::where('id_user', $user->id)->sum('cantidad'),
        ]);
    }

    /**
     * Cambia la cantidad de una línea del carrito.
     */
    public function update(Request $request, Cart $cart)
    {
        abort_unless((int) $cart->id_user === (int) $request->user()->id, 403);

        $max = config('cafeteria.max_unidades_por_producto');
        $datos = $request->validate([
            'cantidad' => ['required', 'integer', 'min:1', 'max:'.$max],
        ]);

        $producto = $cart->producto;

        if ($datos['cantidad'] > $producto->stock) {
            return back()->with('error', "Solo quedan {$producto->stock} unidades de «{$producto->nombre}».");
        }

        $cart->update(['cantidad' => $datos['cantidad']]);

        return back()->with('success', 'Cantidad actualizada.');
    }

    /**
     * Quita un producto del carrito.
     */
    public function destroy(Request $request, Cart $cart)
    {
        abort_unless((int) $cart->id_user === (int) $request->user()->id, 403);

        $cart->delete();

        return back()->with('success', 'Producto eliminado de tu reserva.');
    }

    /**
     * Confirma la reserva: crea la reserva y sus líneas, descuenta el stock
     * y vacía el carrito. Todo en una transacción (o se hace todo o nada).
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'hora_recogida' => ['required', 'date_format:H:i'],
        ]);

        $user = $request->user();
        $hora = Carbon::today()->setTimeFromTimeString($request->input('hora_recogida'));
        $apertura = Carbon::today()->setTimeFromTimeString(config('cafeteria.hora_apertura'));
        $cierre = Carbon::today()->setTimeFromTimeString(config('cafeteria.hora_cierre'));

        if ($hora->lt($apertura) || $hora->gt($cierre)) {
            return back()->withInput()->withErrors([
                'hora_recogida' => 'La cafetería atiende de '.config('cafeteria.hora_apertura').' a '.config('cafeteria.hora_cierre').'.',
            ]);
        }

        $minimo = now()->addMinutes(config('cafeteria.minutos_antelacion'));
        if ($hora->lt($minimo)) {
            return back()->withInput()->withErrors([
                'hora_recogida' => 'Elige una hora posterior a las '.$minimo->format('H:i').'.',
            ]);
        }

        try {
            $reserva = DB::transaction(function () use ($user, $hora) {
                $items = Cart::where('id_user', $user->id)->lockForUpdate()->get();

                if ($items->isEmpty()) {
                    throw new ReservaException('Tu reserva está vacía.');
                }

                $productos = Producto::whereIn('id_producto', $items->pluck('id_producto'))
                    ->lockForUpdate()
                    ->get()
                    ->keyBy('id_producto');

                $total = 0;
                $lineas = [];

                foreach ($items as $item) {
                    $producto = $productos[$item->id_producto];

                    if ($producto->stock < $item->cantidad) {
                        throw new ReservaException(
                            "No queda stock suficiente de «{$producto->nombre}» (quedan {$producto->stock}). Ajusta la cantidad e inténtalo de nuevo."
                        );
                    }

                    $importe = round((float) $producto->precio_unitario * $item->cantidad, 2);
                    $total += $importe;
                    $lineas[] = [$producto, $item->cantidad, $importe];
                }

                $total = round($total, 2);
                $base = round($total / (1 + config('cafeteria.igic') / 100), 2);

                $reserva = Reserva::create([
                    'fecha_reserva' => today()->toDateString(),
                    'hora_recogida' => $hora->format('H:i:s'),
                    'estado' => Reserva::PENDIENTE,
                    'impuesto_IGIC' => round($total - $base, 2),
                    'subtotal' => $base,
                    'descuento_total' => 0,
                    'total' => $total,
                    'id_cliente' => $user->id,
                ]);

                foreach ($lineas as [$producto, $cantidad, $importe]) {
                    Linea_Reserva::create([
                        'id_reserva' => $reserva->id_reserva,
                        'id_producto' => $producto->id_producto,
                        'cantidad' => $cantidad,
                        'importe_linea' => $importe,
                    ]);

                    $producto->decrement('stock', $cantidad);
                }

                Cart::where('id_user', $user->id)->delete();

                return $reserva;
            });
        } catch (ReservaException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->route('reservas.index')
            ->with('success', "¡Reserva #{$reserva->id_reserva} confirmada! Te esperamos a las {$reserva->hora}.");
    }
}
