<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * El orden importa: cada tabla depende de las anteriores (claves foráneas).
     */
    public function run(): void
    {
        $this->call([
            AlmacenTableSeeder::class,
            EstanteriasTableSeeder::class,
            CategoriasTableSeeder::class,
            UsersTableSeeder::class,
            EmpleadosTableSeeder::class,
            ProductosTableSeeder::class,
        ]);
    }
}
