<?php

namespace App\Http\Controllers;

use App\Models\Categoria;

class ProductoController extends Controller
{
    /**
     * Carta de la cafetería: productos agrupados por categoría.
     */
    public function index()
    {
        $categorias = Categoria::with(['productos' => fn ($q) => $q->orderBy('nombre')])
            ->orderBy('id_categoria')
            ->get()
            ->filter(fn ($categoria) => $categoria->productos->isNotEmpty());

        // Datos que usa el modal de detalle (se leen en el navegador, sin más peticiones).
        $mapa = [];
        foreach ($categorias as $categoria) {
            foreach ($categoria->productos as $producto) {
                $mapa[$producto->id_producto] = [
                    'id' => $producto->id_producto,
                    'nombre' => $producto->nombre,
                    'descripcion' => $producto->descripcion,
                    'precio' => number_format((float) $producto->precio_unitario, 2, ',', '.'),
                    'stock' => (int) $producto->stock,
                    'imagen' => asset($producto->imagen),
                    'categoria' => $categoria->nombre,
                ];
            }
        }

        return view('dashboard', [
            'categorias' => $categorias,
            'productosJs' => $mapa,
            'maxUnidades' => config('cafeteria.max_unidades_por_producto'),
        ]);
    }
}
