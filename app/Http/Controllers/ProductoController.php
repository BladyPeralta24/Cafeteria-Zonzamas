<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        // Obtener todos los productos de la base de datos
        $producto = Producto::all();

        // Pasa los productos a la vista
        return view('dashboard', ['productos' => $producto]);
    }
}
