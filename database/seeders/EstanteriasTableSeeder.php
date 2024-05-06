<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Estanteria;

class EstanteriasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Estanteria::create([
            'cod_estanteria' => 1,
            'cod_almacen' => 1,
            'capacidad' => 500,
            'dimensiones' => '1 metro cúbico',
        ]);

        Estanteria::create([
            'cod_estanteria' => 2,
            'cod_almacen' => 1,
            'capacidad' => 500,
            'dimensiones' => '1 metro cúbico',
        ]);

        Estanteria::create([
            'cod_estanteria' => 3,
            'cod_almacen' => 3,
            'capacidad' => 500,
            'dimensiones' => '1,5 metros cúbicos',
        ]);

        Estanteria::create([
            'cod_estanteria' => 4,
            'cod_almacen' => 4,
            'capacidad' => 500,
            'dimensiones' => '1 metro cúbico',
        ]);
    }
}
