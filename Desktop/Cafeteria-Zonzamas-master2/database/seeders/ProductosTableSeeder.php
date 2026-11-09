<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Seeder;

class ProductosTableSeeder extends Seeder
{
    /**
     * Productos de ejemplo. Los precios y el stock son orientativos:
     * edítalos aquí (o en la base de datos) con los reales de la cafetería.
     */
    public function run(): void
    {
        // [id_categoria, cod_estanteria/cod_almacen, nombre, descripción, precio, stock, imagen]
        $productos = [
            // Bebidas
            [1, 1, 'Café solo', 'Café espresso recién hecho.', 0.90, 50, 'cafe.png'],
            [1, 1, 'Cortado corto', 'Café con un toque de leche.', 0.90, 50, 'cafe.png'],
            [1, 1, 'Cortado largo', 'Café con más leche, en vaso grande.', 1.10, 50, 'cafe.png'],
            [1, 1, 'Agua', 'Botella de agua mineral de 50 cl.', 0.80, 40, 'agua.png'],
            [1, 1, 'Refresco', 'Refresco de cola en lata o vaso.', 1.20, 40, 'refresco.png'],
            [1, 1, 'Bebida energética', 'Lata de bebida energética.', 1.50, 30, 'bebida_energetica.png'],
            [1, 1, 'Zumo de naranja', 'Zumo de naranja.', 1.00, 30, 'zumo.png'],

            // Bollerías y snacks
            [2, 2, 'Donut', 'Donut glaseado con grageas.', 1.00, 20, 'donut.png'],
            [2, 2, 'Cookie', 'Galleta grande con pepitas de chocolate.', 1.00, 20, 'cookie.png'],
            [2, 2, 'Oreo', 'Galletas de chocolate rellenas de crema.', 1.00, 25, 'oreos.png'],
            [2, 2, 'Chocolatina', 'Tableta de chocolate con leche.', 0.80, 30, 'chocolatina.png'],
            [2, 2, 'Tirma', 'Barrita de barquillo y chocolate.', 0.60, 30, 'tirma.png'],
            [2, 2, 'Patatas fritas', 'Bolsa de patatas fritas.', 1.00, 30, 'patata.png'],
            [2, 2, 'Frutos secos', 'Bolsita de frutos secos variados.', 1.20, 25, 'frutos_secos.png'],
            [2, 2, 'Tortitas de arroz', 'Tortitas de arroz inflado.', 0.90, 25, 'tortas_arroz.png'],
            [2, 2, "M&M's", 'Lentejas de chocolate con cacahuete.', 1.20, 25, 'mms.png'],
            [2, 2, 'Chuches', 'Surtido de golosinas.', 0.50, 40, 'chuches.png'],
            [2, 2, 'Chicles', 'Paquete de chicles.', 0.60, 40, 'chicles.png'],
            [2, 2, 'Mentos', 'Rollo de caramelos de menta.', 0.70, 40, 'mentos.png'],

            // Pulgas
            [3, 3, 'Pulga', 'Pulga de jamón y queso.', 1.50, 20, 'pulga.png'],

            // Bocadillos
            [4, 3, 'Bocadillo', 'Bocadillo de jamón, queso y ensalada.', 2.50, 20, 'bocadillo.png'],
            [4, 3, 'Pan pizza', 'Pan tostado al estilo pizza.', 2.00, 15, 'PanPizza.png'],

            // Sandwiches
            [5, 4, 'Sandwich mixto', 'Sandwich de jamón y queso.', 1.80, 20, 'sandwich.png'],
        ];

        foreach ($productos as $i => [$categoria, $estanteria, $nombre, $descripcion, $precio, $stock, $imagen]) {
            Producto::updateOrCreate(['id_producto' => $i + 1], [
                'nombre' => $nombre,
                'descripcion' => $descripcion,
                'precio_unitario' => $precio,
                'stock' => $stock,
                // Siempre con "/" (con "\" la URL de la imagen se rompe).
                'imagen' => 'img/img_bbdd/'.$imagen,
                'id_categoria' => $categoria,
                'cod_estanteria' => $estanteria,
                'cod_almacen' => $estanteria,
            ]);
        }
    }
}
