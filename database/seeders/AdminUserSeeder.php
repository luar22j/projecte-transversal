<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@burgersandroll.com'],
            [
                'nombre' => 'Admin',
                'apellidos' => 'Sistema',
                'password' => bcrypt('Admin123!'),
                'telefono' => '666777888',
                'fecha_nacimiento' => '1990-01-01',
                'direccion' => 'Calle Admin 123',
                'direccion_envio' => 'Calle Admin 123',
                'email_verified_at' => now(),
            ]
        );

        // Asignar rol de administrador si no lo tiene
        $adminRole = Role::where('nombre', 'admin')->first();
        if ($adminRole && !$admin->hasRole('admin')) {
            $admin->roles()->attach($adminRole);
        }
    }
} 