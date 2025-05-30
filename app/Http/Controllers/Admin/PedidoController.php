<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use App\Models\EstadoPedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index(Request $request)
    {
        $pedidos = Pedido::with(['user', 'detalles.producto', 'estado'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        if ($request->expectsJson()) {
            return response()->json($pedidos);
        }

        return view('admin.pedidos.index', compact('pedidos'));
    }

    public function show(Pedido $pedido)
    {
        $pedido->load(['user', 'detalles.producto']);

        if (request()->expectsJson()) {
            return response()->json($pedido);
        }

        return view('admin.pedidos.show', compact('pedido'));
    }

    public function actualizarEstado(Request $request, Pedido $pedido)
    {
        $request->validate([
            'estado' => 'required|in:pendiente,en_proceso,enviado,entregado,cancelado'
        ]);

        // Buscar el ID del estado correspondiente
        $estado = EstadoPedido::where('nombre', $request->estado)->first();
        
        if (!$estado) {
            return response()->json([
                'message' => 'Estado no válido'
            ], 422);
        }

        $pedido->estado_id = $estado->id;
        $pedido->save();

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Estado del pedido actualizado correctamente',
                'pedido' => $pedido->load(['estado', 'user', 'detalles.producto'])
            ]);
        }

        return redirect()->back()->with('success', 'Estado del pedido actualizado correctamente');
    }

    public function destroy(Pedido $pedido)
    {
        $pedido->delete();
        return redirect()->route('admin.pedidos.index')
            ->with('success', 'Pedido eliminado exitosamente.');
    }
} 