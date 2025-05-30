<?php

namespace Database\Seeders;

use App\Models\Subcategoria;
use App\Models\Categoria;
use Illuminate\Database\Seeder;

class SubcategoriaSeeder extends Seeder
{
    public function run()
    {
        // Obtener las categorías
        $categoriaMenus = Categoria::where('slug', 'menus')->first();
        $categoriaBurgers = Categoria::where('slug', 'hamburguesas')->first();
        $categoriaBebidas = Categoria::where('slug', 'bebidas')->first();
        $categoriaPostres = Categoria::where('slug', 'postres')->first();

        if (!$categoriaMenus || !$categoriaBurgers || !$categoriaBebidas || !$categoriaPostres) {
            throw new \Exception('Las categorías no existen. Asegúrate de que el DatabaseSeeder se ha ejecutado primero.');
        }

        // Subcategorías para Menús
        $subcategoriasMenus = [
            [
                'nombre' => 'Menús Individuales',
                'descripcion' => 'Menús para una persona'
            ],
            [
                'nombre' => 'Menús Familiares',
                'descripcion' => 'Menús para compartir en familia'
            ]
        ];

        // Subcategorías para Hamburguesas
        $subcategoriasBurgers = [
            [
                'nombre' => 'Hamburguesas Clásicas',
                'descripcion' => 'Nuestras hamburguesas tradicionales'
            ],
            [
                'nombre' => 'Hamburguesas Gourmet',
                'descripcion' => 'Hamburguesas con ingredientes premium'
            ]
        ];

        // Subcategorías para Bebidas
        $subcategoriasBebidas = [
            [
                'nombre' => 'Refrescos',
                'descripcion' => 'Bebidas carbonatadas y refrescos'
            ],
            [
                'nombre' => 'Zumos Naturales',
                'descripcion' => 'Zumos recién exprimidos'
            ]
        ];

        // Subcategorías para Postres
        $subcategoriasPostres = [
            [
                'nombre' => 'Helados',
                'descripcion' => 'Nuestros deliciosos helados'
            ],
            [
                'nombre' => 'Postres Caseros',
                'descripcion' => 'Postres elaborados artesanalmente'
            ]
        ];

        // Insertar subcategorías
        foreach ($subcategoriasMenus as $subcategoria) {
            Subcategoria::firstOrCreate(
                ['nombre' => $subcategoria['nombre']],
                array_merge($subcategoria, ['categoria_id' => $categoriaMenus->id])
            );
        }

        foreach ($subcategoriasBurgers as $subcategoria) {
            Subcategoria::firstOrCreate(
                ['nombre' => $subcategoria['nombre']],
                array_merge($subcategoria, ['categoria_id' => $categoriaBurgers->id])
            );
        }

        foreach ($subcategoriasBebidas as $subcategoria) {
            Subcategoria::firstOrCreate(
                ['nombre' => $subcategoria['nombre']],
                array_merge($subcategoria, ['categoria_id' => $categoriaBebidas->id])
            );
        }

        foreach ($subcategoriasPostres as $subcategoria) {
            Subcategoria::firstOrCreate(
                ['nombre' => $subcategoria['nombre']],
                array_merge($subcategoria, ['categoria_id' => $categoriaPostres->id])
            );
        }
    }
} 