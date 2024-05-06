<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Categoria::create([
            'id_categoria' => 1,
            'nombre' => 'Bebidas',
            'descripcion' => 'Bebidas de todo tipo. Desde frías hasta calientes.',
        ]);

        Categoria::create([
            'id_categoria' => 2,
            'nombre' => 'Bollerias',
            'descripcion' => 'Bollerias industriales de todo tipo. Desde dulces hasta saladas.',
        ]);

        Categoria::create([
            'id_categoria' => 3,
            'nombre' => 'Pulgas',
            'descripcion' => 'Bocadillos de tamaño reducido. Ideales para picar entre horas.',
        ]);

        Categoria::create([
            'id_categoria' => 4,
            'nombre' => 'Bocadillos',
            'descripcion' => 'Bocadillos de tamaño normal. Ideales para comer en cualquier momento.',
        ]);

        Categoria::create([
            'id_categoria' => 5,
            'nombre' => 'Sandwiches',
            'descripcion' => 'Pan de molde con ingredientes variados.',
        ]);
    }
}
