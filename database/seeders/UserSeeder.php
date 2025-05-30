<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Primero creamos el rol si no existe
        $role = Role::firstOrCreate(
            ['nombre' => 'user'],
            ['description' => 'Usuario normal']
        );

        // Luego creamos el usuario
        $user = User::firstOrCreate(
            ['email' => 'luarjaen@gmail.com'],
            [
                'nombre' => 'Luar',
                'apellidos' => 'Jaen',
                'password' => Hash::make('Admin123!'),
                'telefono' => '666777888',
                'fecha_nacimiento' => '1990-01-01',
                'direccion_envio' => 'Calle Principal 123',
                'direccion_facturacion' => 'Calle Principal 123',
                'email_verified_at' => now(),
            ]
        );

        // Asignamos el rol al usuario
        if (!$user->hasRole('user')) {
            $user->roles()->attach($role);
        }
    }
}
