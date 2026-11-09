<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriasTableSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            1 => ['Bebidas', 'Bebidas de todo tipo. Desde frías hasta calientes.'],
            2 => ['Bollerías y snacks', 'Bollería industrial, dulces y snacks para picar entre horas.'],
            3 => ['Pulgas', 'Bocadillos de tamaño reducido. Ideales para picar entre horas.'],
            4 => ['Bocadillos', 'Bocadillos de tamaño normal. Ideales para comer en cualquier momento.'],
            5 => ['Sandwiches', 'Pan de molde con ingredientes variados.'],
        ];

        foreach ($categorias as $id => [$nombre, $descripcion]) {
            Categoria::updateOrCreate(['id_categoria' => $id], [
                'nombre' => $nombre,
                'descripcion' => $descripcion,
            ]);
        }
    }
}
