<?php

namespace Database\Seeders;

use App\Models\Almacen;
use Illuminate\Database\Seeder;

class AlmacenTableSeeder extends Seeder
{
    public function run(): void
    {
        $almacenes = [
            1 => 'Sección de bebidas',
            2 => 'Sección de bollerías y snacks',
            3 => 'Sección de bocadillos y pulgas',
            4 => 'Sección de sandwiches',
        ];

        foreach ($almacenes as $cod => $direccion) {
            Almacen::updateOrCreate(['cod_almacen' => $cod], ['direccion' => $direccion]);
        }
    }
}
