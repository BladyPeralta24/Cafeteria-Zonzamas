<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Empleado;

class EmpleadosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Empleado::create([
            'id_empleado' => 6,
            'fecha_contratacion' => '2019-01-15',
            'puesto' => 'Gerente/Cocinero',
        ]);

        Empleado::create([
            'id_empleado' => 7,
            'fecha_contratacion' => '2019-01-15',
            'puesto' => 'Camarero/a',
        ]);
    }
}
