<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'nombre' => 'admin',
                'description' => 'Administrador del sistema'
            ],
            [
                'nombre' => 'user',
                'description' => 'Usuario normal'
            ]
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['nombre' => $role['nombre']],
                ['description' => $role['description']]
            );
        }
    }
}
