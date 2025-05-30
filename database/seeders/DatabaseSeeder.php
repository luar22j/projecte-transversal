<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use App\Models\Estado;
use Illuminate\Support\Facades\Hash;
use App\Models\Categoria;
use App\Models\Subcategoria;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Crear roles
        $adminRole = Role::firstOrCreate(
            ['nombre' => 'admin'],
            ['description' => 'Administrador del sistema']
        );

        $userRole = Role::firstOrCreate(
            ['nombre' => 'user'],
            ['description' => 'Usuario normal']
        );

        // Ejecutar el seeder de usuario administrador
        $this->call(AdminUserSeeder::class);

        // Crear estados si no existen
        $estados = [
            ['nombre' => 'Pendiente'],
            ['nombre' => 'En preparación'],
            ['nombre' => 'Listo para recoger'],
            ['nombre' => 'Entregado'],
            ['nombre' => 'Cancelado']
        ];

        foreach ($estados as $estado) {
            Estado::firstOrCreate(['nombre' => $estado['nombre']], $estado);
        }

        // Crear categorías para el marketplace
        $categorias = [
            [
                'nombre' => 'Menús',
                'slug' => 'menus',
                'descripcion' => 'Nuestros menús especiales'
            ],
            [
                'nombre' => 'Hamburguesas',
                'slug' => 'hamburguesas',
                'descripcion' => 'Nuestras deliciosas hamburguesas'
            ],
            [
                'nombre' => 'Bebidas',
                'slug' => 'bebidas',
                'descripcion' => 'Nuestras refrescantes bebidas'
            ],
            [
                'nombre' => 'Postres',
                'slug' => 'postres',
                'descripcion' => 'Nuestros deliciosos postres'
            ]
        ];

        foreach ($categorias as $categoria) {
            Categoria::firstOrCreate(['slug' => $categoria['slug']], $categoria);
        }

        // Ejecutar el seeder de subcategorías
        $this->call(SubcategoriaSeeder::class);

        // Ejecutar el seeder de productos
        $this->call(ProductosSeeder::class);
    }
}