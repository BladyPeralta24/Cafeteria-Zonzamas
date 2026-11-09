<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Usuarios de prueba. CAMBIA LAS CONTRASEÑAS si publicas la web.
     * La contraseña de todos es: password
     */
    public function run(): void
    {
        $usuarios = [
            ['admin', '600000001', 'admin@admin.es', 'admin'],
            ['Gerente Zonzamas', '600000002', 'gerente@zonzamas.es', 'empleado'],
            ['Camarero Zonzamas', '600000003', 'camarero@zonzamas.es', 'empleado'],
            ['Cliente de prueba', '600000004', 'cliente@zonzamas.es', 'cliente'],
        ];

        foreach ($usuarios as [$name, $telefono, $email, $tipo]) {
            // La contraseña se pasa en claro: el cast "hashed" del modelo la cifra.
            User::updateOrCreate(['email' => $email], [
                'name' => $name,
                'telefono' => $telefono,
                'email_verified_at' => now(),
                'password' => 'password',
                'tipo' => $tipo,
            ]);
        }
    }
}
