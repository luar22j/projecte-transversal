<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventarioController extends Controller
{
    public function index(Request $request)
    {
        $query = Producto::with(['subcategoria' => function($query) {
                $query->with('categoria');
            }])
            ->select('id', 'nombre', 'stock', 'precio', 'subcategoria_id')
            ->withCount('pedidos as total_vendido')
            ->where('stock', '>', 0); // Solo mostrar productos con stock

        // Ordenar por stock
        if ($request->has('ordenar')) {
            $orden = $request->input('ordenar', 'asc');
            $query->orderBy('stock', $orden);
        }

        $productos = $query->paginate(10);

        if ($request->expectsJson()) {
            return response()->json($productos);
        }

        return view('admin.inventario.index', compact('productos'));
    }

    public function actualizarStock(Request $request, Producto $producto)
    {
        $validated = $request->validate([
            'stock' => 'required|integer|min:0'
        ]);

        $producto->update($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Stock actualizado correctamente',
                'producto' => $producto
            ]);
        }

        return redirect()->back()->with('success', 'Stock actualizado correctamente');
    }

    public function show(Producto $producto)
    {
        $producto->load(['subcategoria' => function($query) {
            $query->with('categoria');
        }]);

        $producto->loadCount('pedidos as total_vendido');

        // Obtener la última venta
        $ultimaVenta = DB::table('detalles_pedido')
            ->where('producto_id', $producto->id)
            ->join('pedidos', 'detalles_pedido.pedido_id', '=', 'pedidos.id')
            ->orderBy('pedidos.created_at', 'desc')
            ->first();

        $producto->ultima_venta = $ultimaVenta ? $ultimaVenta->created_at : null;

        return response()->json($producto);
    }

    public function productosAgotados()
    {
        $productos = Producto::where('stock', 0)
            ->with(['categoria', 'subcategoria'])
            ->select('id', 'nombre', 'stock', 'precio', 'imagen', 'categoria_id', 'subcategoria_id')
            ->withCount('pedidos as total_vendido')
            ->paginate(10);

        return view('admin.inventario.agotados', compact('productos'));
    }

    public function masVendidos()
    {
        $productos = Producto::with(['categoria', 'subcategoria'])
            ->select('id', 'nombre', 'stock', 'precio', 'imagen', 'categoria_id', 'subcategoria_id')
            ->withCount('pedidos as total_vendido')
            ->orderBy('total_vendido', 'desc')
            ->paginate(10);

        return view('admin.inventario.mas-vendidos', compact('productos'));
    }

    public function getEstadisticas()
    {
        $estadisticas = [
            'total_productos' => Producto::count(),
            'productos_agotados' => Producto::where('stock', '<=', 0)->count(),
            'productos_bajo_stock' => Producto::where('stock', '<=', 5)->where('stock', '>', 0)->count(),
            'productos_sin_ventas' => Producto::whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('detalles_pedido')
                    ->whereRaw('detalles_pedido.producto_id = productos.id');
            })->count(),
            'productos_mas_vendidos' => Producto::select('productos.*', 
                DB::raw('(SELECT SUM(cantidad) FROM detalles_pedido WHERE producto_id = productos.id) as ventas_totales'))
                ->orderBy('ventas_totales', 'desc')
                ->take(5)
                ->get()
        ];

        return response()->json($estadisticas);
    }
} 