<?php

namespace Database\Seeders;

use App\Models\Estanteria;
use Illuminate\Database\Seeder;

class EstanteriasTableSeeder extends Seeder
{
    public function run(): void
    {
        // cod_estanteria => [cod_almacen, capacidad, dimensiones]
        $estanterias = [
            1 => [1, 500, '1 metro cúbico'],
            2 => [2, 500, '1 metro cúbico'],
            3 => [3, 500, '1,5 metros cúbicos'],
            4 => [4, 500, '1 metro cúbico'],
        ];

        foreach ($estanterias as $cod => [$almacen, $capacidad, $dimensiones]) {
            Estanteria::updateOrCreate(['cod_estanteria' => $cod], [
                'cod_almacen' => $almacen,
                'capacidad' => $capacidad,
                'dimensiones' => $dimensiones,
            ]);
        }
    }
}
