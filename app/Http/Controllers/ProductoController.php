<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        // Obtener todos los productos de la base de datos
        /* $producto = Producto::all(); */
        $categorias = Categoria::with('productos')->get();
        $producto = Producto::whereHas('categoria')->with('categoria')->get()->sortBy('categoria.nombre');

        // Pasa los productos a la vista
        /* return view('dashboard', ['productos' => $producto]); */

        return view('dashboard', ['categorias' => $categorias]);


    }
}
