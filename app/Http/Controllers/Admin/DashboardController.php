<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function getData()
    {
        // Obtener el rol de usuario normal
        $userRole = Role::where('nombre', 'user')->first();
        
        // Contar usuarios normales
        $totalUsers = $userRole ? $userRole->users()->count() : 0;
        
        // Obtener estadísticas de pedidos
        $totalPedidos = Pedido::count();
        
        // Obtener estadísticas de productos
        $totalProductos = Producto::count();

        // Pedidos recientes
        $recentOrders = Pedido::with(['user', 'estado'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($pedido) {
                return [
                    'id' => $pedido->id,
                    'cliente' => $pedido->user->nombre . ' ' . $pedido->user->apellidos,
                    'total' => number_format($pedido->total, 2),
                    'estado' => $pedido->estado->nombre,
                    'fecha' => $pedido->created_at->format('d/m/Y H:i')
                ];
            });

        // Productos más vendidos
        $topProducts = Producto::with(['subcategoria.categoria'])
            ->select('productos.*', DB::raw('(SELECT SUM(cantidad) FROM detalles_pedido WHERE producto_id = productos.id) as ventas'))
            ->orderBy('ventas', 'desc')
            ->take(5)
            ->get()
            ->map(function ($producto) {
                return [
                    'nombre' => $producto->nombre,
                    'categoria' => $producto->subcategoria?->categoria?->nombre ?? 'Sin categoría',
                    'ventas' => $producto->ventas ?? 0,
                    'stock' => $producto->stock,
                    'estado' => $producto->stock > 0 ? 'Disponible' : 'Sin Stock'
                ];
            });

        return response()->json([
            'totalUsers' => $totalUsers,
            'totalPedidos' => $totalPedidos,
            'totalProductos' => $totalProductos,
            'recentOrders' => $recentOrders,
            'topProducts' => $topProducts
        ]);
    }
}
