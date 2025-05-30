<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarritoController extends Controller
{
    public function index()
    {
        $items = Carrito::where('user_id', Auth::id())
            ->with('producto')
            ->get();
        
        $total = $items->sum(function ($item) {
            return $item->cantidad * $item->producto->precio;
        });

        return view('carrito.index', compact('items', 'total'));
    }

    public function getItems()
    {
        $items = Carrito::where('user_id', Auth::id())
            ->with('producto')
            ->get();
        
        $total = $items->sum(function ($item) {
            return $item->cantidad * $item->producto->precio;
        });

        return response()->json([
            'items' => $items,
            'total' => $total
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:productos,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $producto = Producto::findOrFail($request->product_id);
        
        if (Auth::check()) {
            // Si el usuario está autenticado, guardar en la base de datos
            $carritoItem = Carrito::where('user_id', Auth::id())
                ->where('producto_id', $request->product_id)
                ->first();

            if ($carritoItem) {
                $carritoItem->cantidad += $request->quantity;
                $carritoItem->save();
            } else {
                Carrito::create([
                    'user_id' => Auth::id(),
                    'producto_id' => $request->product_id,
                    'cantidad' => $request->quantity,
                    'precio_unitario' => $producto->precio,
                    'subtotal' => $producto->precio * $request->quantity
                ]);
            }
        } else {
            // Si el usuario no está autenticado, guardar en la sesión
            $carrito = session()->get('carrito', []);
            
            if (isset($carrito[$request->product_id])) {
                $carrito[$request->product_id]['cantidad'] += $request->quantity;
            } else {
                $carrito[$request->product_id] = [
                    'id' => $producto->id,
                    'nombre' => $producto->nombre,
                    'precio' => $producto->precio,
                    'imagen' => $producto->imagen,
                    'cantidad' => $request->quantity
                ];
            }
            
            session()->put('carrito', $carrito);
        }

        return response()->json([
            'message' => 'Producto añadido al carrito'
        ]);
    }

    public function update(Request $request, Carrito $carrito)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        if ($carrito->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'No autorizado'
            ], 403);
        }

        $carrito->cantidad = $request->quantity;
        $carrito->save();

        return response()->json([
            'message' => 'Cantidad actualizada'
        ]);
    }

    public function destroy(Carrito $carrito)
    {
        if ($carrito->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'No autorizado'
            ], 403);
        }

        $carrito->delete();

        return response()->json([
            'message' => 'Producto eliminado del carrito'
        ]);
    }

    public function clear()
    {
        Carrito::where('user_id', Auth::id())->delete();

        return response()->json([
            'message' => 'Carrito vaciado'
        ]);
    }
}
