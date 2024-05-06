<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        /* User::factory()
            ->count(5)
            ->create(); */

        /* Crear un usuario que sera el admin */
        User::create([
            'name' => 'admin',
            'telefono' => '1234567890',
            'email' => 'admin@admin.es',
            'email_verified_at' => now(),
            'password' => bcrypt('contraseña'),
            'tipo' => 'admin',
        ]);
    }
}
