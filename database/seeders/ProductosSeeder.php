<?php

namespace Database\Seeders;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Database\Seeder;

class ProductosSeeder extends Seeder
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

        // Menús
        $menus = [
            [
                'nombre' => 'MENÚ ROLLER',
                'descripcion' => 'Hamburguesa Roller, patatas fritas, bebida y postre',
                'precio' => 12.50,
                'imagen' => 'marketplace/menu.png',
                'stock' => 50,
                'ingredientes' => json_encode([
                    'Hamburguesa Roller',
                    'Patatas fritas',
                    'Bebida a elegir',
                    'Postre a elegir'
                ])
            ],
            [
                'nombre' => 'MENÚ BACON KING',
                'descripcion' => 'Hamburguesa Bacon King, patatas fritas, bebida y postre',
                'precio' => 15.50,
                'imagen' => 'marketplace/menu2.png',
                'stock' => 50,
                'ingredientes' => json_encode([
                    'Hamburguesa Bacon King',
                    'Patatas fritas',
                    'Bebida a elegir',
                    'Postre a elegir'
                ])
            ],
            [
                'nombre' => 'MENÚ FAMILIAR',
                'descripcion' => '4 hamburguesas Roller, 4 patatas fritas, 4 bebidas y 2 postres',
                'precio' => 45.00,
                'imagen' => 'marketplace/menu3.png',
                'stock' => 30,
                'ingredientes' => json_encode([
                    '4 Hamburguesas Roller',
                    '4 Patatas fritas',
                    '4 Bebidas a elegir',
                    '2 Postres a elegir'
                ])
            ]
        ];

        // Hamburguesas
        $burgers = [
            [
                'nombre' => 'BACON KING',
                'descripcion' => 'Crea tu hamburguesa perfecta eligiendo todos los ingredientes a tu gusto',
                'precio' => 12.50,
                'imagen' => 'marketplace/burger3.png',
                'stock' => 100,
                'ingredientes' => json_encode([
                    'Pan brioche',
                    'Carne de vacuno 150g',
                    'Queso cheddar',
                    'Bacon crujiente',
                    'Lechuga',
                    'Tomate',
                    'Cebolla caramelizada',
                ])
            ],
            [
                'nombre' => 'ROLLER BURGER',
                'descripcion' => 'Nuestra hamburguesa estrella con los mejores ingredientes seleccionados',
                'precio' => 9.50,
                'imagen' => 'marketplace/burger2.png',
                'stock' => 100,
                'ingredientes' => json_encode([
                    'Pan brioche',
                    'Carne de vacuno 150g',
                    'Queso cheddar',
                    'Lechuga',
                    'Tomate',
                    'Cebolla caramelizada',
                    'Salsa especial Roller'
                ])
            ],
            [
                'nombre' => 'DOBLE CHEESE',
                'descripcion' => 'Doble carne y doble queso para los más hambrientos',
                'precio' => 11.50,
                'imagen' => 'marketplace/burger4.png',
                'stock' => 100,
                'ingredientes' => json_encode([
                    'Pan brioche',
                    '2x Carne de vacuno 150g',
                    '2x Queso cheddar',
                    'Lechuga',
                    'Tomate',
                    'Cebolla caramelizada',
                    'Salsa especial Roller'
                ])
            ],
            [
                'nombre' => 'VEGGIE BURGER',
                'descripcion' => 'Hamburguesa vegetariana con ingredientes frescos',
                'precio' => 10.50,
                'imagen' => 'marketplace/burger5.png',
                'stock' => 80,
                'ingredientes' => json_encode([
                    'Pan integral',
                    'Hamburguesa de garbanzos y quinoa',
                    'Queso vegano',
                    'Lechuga',
                    'Tomate',
                    'Aguacate',
                    'Salsa de yogur'
                ])
            ]
        ];

        // Bebidas
        $bebidas = [
            [
                'nombre' => 'COLA',
                'descripcion' => 'Refresco de cola con gas, servido bien frío con hielo',
                'precio' => 1.50,
                'imagen' => 'marketplace/drink.png',
                'stock' => 200,
                'ingredientes' => json_encode([
                    'Refresco de cola',
                    'Hielo',
                    'Opcional: rodaja de limón',
                    'Capacidad: 500ml'
                ])
            ],
            [
                'nombre' => 'ZUMO NARANJA',
                'descripcion' => 'Zumo de naranja natural recién exprimido',
                'precio' => 1.50,
                'imagen' => 'marketplace/drink2.png',
                'stock' => 150,
                'ingredientes' => json_encode([
                    'Naranjas naturales',
                    'Sin azúcares añadidos',
                    'Sin conservantes',
                    'Capacidad: 400ml'
                ])
            ],
            [
                'nombre' => 'LIMONADA',
                'descripcion' => 'Limonada casera con menta y jengibre',
                'precio' => 2.00,
                'imagen' => 'marketplace/drink3.png',
                'stock' => 150,
                'ingredientes' => json_encode([
                    'Limones frescos',
                    'Menta',
                    'Jengibre',
                    'Agua mineral',
                    'Capacidad: 500ml'
                ])
            ],
            [
                'nombre' => 'AGUA',
                'descripcion' => 'Agua mineral con gas',
                'precio' => 1.50,
                'imagen' => 'marketplace/drink4.png',
                'stock' => 100,
                'ingredientes' => json_encode([
                    'Agua mineral',
                    'Capacidad: 500ml'
                ])
            ]
        ];

        // Postres
        $postres = [
            [
                'nombre' => 'HELADO DE CHOCOLATE',
                'descripcion' => 'Helado cremoso de chocolate belga con trozos de chocolate negro',
                'precio' => 4.50,
                'imagen' => 'marketplace/dessert.png',
                'stock' => 80,
                'ingredientes' => json_encode([
                    'Helado de chocolate belga',
                    'Trozos de chocolate negro 70%',
                    'Nata montada',
                    'Sirope de chocolate',
                    'Virutas de chocolate'
                ])
            ],
            [
                'nombre' => 'HELADO COOKIE',
                'descripcion' => 'Helado de vainilla con trozos de galleta y sirope de chocolate',
                'precio' => 4.50,
                'imagen' => 'marketplace/dessert2.png',
                'stock' => 80,
                'ingredientes' => json_encode([
                    'Helado de vainilla',
                    'Trozos de galleta Oreo',
                    'Sirope de chocolate',
                    'Nata montada',
                    'Galleta Oreo entera de decoración'
                ])
            ],
            [
                'nombre' => 'HELADO DE NUECES',
                'descripcion' => 'Helado de nueces con nata montada',
                'precio' => 5.00,
                'imagen' => 'marketplace/dessert3.png',
                'stock' => 60,
                'ingredientes' => json_encode([
                    'Helado de nueces',
                    'Nata montada',
                    'Sirope de caramelo'
                ])
            ],
            [
                'nombre' => 'GOFRES',
                'descripcion' => 'Gofres con helado de vainilla',
                'precio' => 4.50,
                'imagen' => 'marketplace/dessert4.png',
                'stock' => 60,
                'ingredientes' => json_encode([
                    'Gofres',
                    'Helado de vainilla',
                    'Sirope de chocolate',
                    'Nata montada'
                ])
            ]
        ];

        // Insertar productos
        foreach ($menus as $menu) {
            Producto::updateOrCreate(
                ['nombre' => $menu['nombre']],
                array_merge($menu, ['categoria_id' => $categoriaMenus->id])
            );
        }

        foreach ($burgers as $burger) {
            Producto::updateOrCreate(
                ['nombre' => $burger['nombre']],
                array_merge($burger, ['categoria_id' => $categoriaBurgers->id])
            );
        }

        foreach ($bebidas as $bebida) {
            Producto::updateOrCreate(
                ['nombre' => $bebida['nombre']],
                array_merge($bebida, ['categoria_id' => $categoriaBebidas->id])
            );
        }

        foreach ($postres as $postre) {
            Producto::updateOrCreate(
                ['nombre' => $postre['nombre']],
                array_merge($postre, ['categoria_id' => $categoriaPostres->id])
            );
        }
    }
} 