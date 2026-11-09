<?php

namespace Database\Seeders;

use App\Models\Empleado;
use App\Models\User;
use Illuminate\Database\Seeder;

class EmpleadosTableSeeder extends Seeder
{
    public function run(): void
    {
        $empleados = [
            'gerente@zonzamas.es' => 'Gerente/Cocinero',
            'camarero@zonzamas.es' => 'Camarero/a',
        ];

        foreach ($empleados as $email => $puesto) {
            $usuario = User::where('email', $email)->firstOrFail();

            Empleado::updateOrCreate(['id_empleado' => $usuario->id], [
                'fecha_contratacion' => '2019-01-15',
                'puesto' => $puesto,
            ]);
        }
    }
}
