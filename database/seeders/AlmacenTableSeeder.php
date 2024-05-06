<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Almacen;

class AlmacenTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Almacen::create([
            'cod_almacen' => 5,
            'direccion' => 'Sección de bebidas',
        ]);

        Almacen::create([
            'cod_almacen' => 6,
            'direccion' => 'Sección de Bollerias',
        ]);

        Almacen::create([
            'cod_almacen' => 7,
            'direccion' => 'Sección de Bocadillos',
        ]);

        Almacen::create([
            'cod_almacen' => 8,
            'direccion' => 'Sección de Sandwiches',
        ]);
    }
}
