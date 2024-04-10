<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EjemploControlador extends Controller
{
    // ejemplo de metodo para que se visualice en la ruta
    public function metodo()
    {
        return view('app');
    }
}
