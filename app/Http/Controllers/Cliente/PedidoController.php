<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use App\Services\FacturaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    protected $facturaService;

    public function __construct(FacturaService $facturaService)
    {
        $this->facturaService = $facturaService;
    }

    public function index()
    {
        $pedidos = Pedido::where('user_id', Auth::id())
            ->with(['detalles.producto', 'estado'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('cliente.pedidos.index', compact('pedidos'));
    }

    public function show(Pedido $pedido)
    {
        if ($pedido->user_id !== Auth::id()) {
            return redirect()->route('cliente.pedidos.index')
                ->with('error', 'No tienes permiso para ver este pedido');
        }

        $pedido->load(['detalles.producto', 'estado']);

        return view('cliente.pedidos.show', compact('pedido'));
    }

    public function descargarFactura(Pedido $pedido)
    {
        if ($pedido->user_id !== Auth::id()) {
            abort(403);
        }

        return $this->facturaService->descargarFactura($pedido);
    }

    public function cancelar(Pedido $pedido)
    {
        if ($pedido->user_id !== Auth::id()) {
            return redirect()->route('cliente.pedidos.index')
                ->with('error', 'No tienes permiso para cancelar este pedido');
        }

        if ($pedido->estado->nombre !== 'pendiente') {
            return redirect()->route('cliente.pedidos.show', $pedido)
                ->with('error', 'Solo se pueden cancelar pedidos pendientes');
        }

        $pedido->update([
            'estado_id' => 4 // ID del estado "cancelado"
        ]);

        return redirect()->route('cliente.pedidos.show', $pedido)
            ->with('success', 'Pedido cancelado correctamente');
    }
} 