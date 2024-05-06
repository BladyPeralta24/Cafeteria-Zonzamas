<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Producto;

class ProductosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Producto::create([
            'id_producto' => 1,
            'nombre' => 'Café solo',
            'precio_unitario' => 0.90,
            'stock' => 10,
            'imagen' => 'img\img_bbdd\cafe.png',
            'id_categoria' => 1,
            'cod_estanteria' => 1,
            'cod_almacen' => 1,
        ]);

        Producto::create([
            'id_producto' => 2,
            'nombre' => 'Cortado corto',
            'precio_unitario' => 0.90,
            'stock' => 10,
            'imagen' => 'img\img_bbdd\cafe.png',
            'id_categoria' => 1,
            'cod_estanteria' => 1,
            'cod_almacen' => 1,
        ]);

        Producto::create([
            'id_producto' => 3,
            'nombre' => 'Cortado largo',
            'precio_unitario' => 1.10,
            'stock' => 10,
            'imagen' => 'img\img_bbdd\cafe.png',
            'id_categoria' => 1,
            'cod_estanteria' => 1,
            'cod_almacen' => 1,
        ]);
    }
}
