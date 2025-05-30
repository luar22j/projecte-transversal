<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\PedidoDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\FacturaService;
use App\Models\Producto;

class CheckoutController extends Controller
{
    protected $facturaService;
    const ENVIO_COSTE = 3.50;
    const ENVIO_GRATIS_MINIMO = 20.00;

    public function __construct(FacturaService $facturaService)
    {
        $this->facturaService = $facturaService;
    }

    public function index()
    {
        $user = Auth::user();
        return view('checkout.index', compact('user'));
    }

    public function store(Request $request)
    {
        try {
            // Validar los datos de la tarjeta y envío
            $request->validate([
                'nombre' => 'required|string|max:255',
                'numero' => 'required|string|size:16|regex:/^[0-9]+$/',
                'expiracion' => ['required', 'string', 'regex:/^(0[1-9]|1[0-2])\/([0-9]{2})$/'],
                'cvv' => 'required|string|size:3|regex:/^[0-9]+$/',
                'direccion_envio' => 'required|string|max:255',
                'codigo_postal' => 'required|string|max:10',
                'ciudad' => 'required|string|max:100',
                'telefono' => 'required|string|max:20',
            ], [
                'numero.required' => 'El número de tarjeta es obligatorio',
                'numero.size' => 'El número de tarjeta debe tener 16 dígitos',
                'numero.regex' => 'El número de tarjeta solo debe contener números',
                'expiracion.required' => 'La fecha de expiración es obligatoria',
                'expiracion.regex' => 'La fecha de expiración debe tener el formato MM/YY',
                'cvv.required' => 'El CVV es obligatorio',
                'cvv.size' => 'El CVV debe tener 3 dígitos',
                'cvv.regex' => 'El CVV solo debe contener números',
                'direccion_envio.required' => 'La dirección de envío es obligatoria',
                'codigo_postal.required' => 'El código postal es obligatorio',
                'ciudad.required' => 'La ciudad es obligatoria',
                'telefono.required' => 'El teléfono es obligatorio',
            ]);

            // Simular procesamiento del pago
            $numeroTarjeta = $request->numero;
            $ultimosDigitos = substr($numeroTarjeta, -4);
            
            // Simular validación de tarjeta (en un caso real, esto lo haría la pasarela de pago)
            if ($numeroTarjeta[0] === '0') {
                throw new \Exception('Tarjeta rechazada: Número de tarjeta inválido');
            }

            DB::beginTransaction();

            // Calcular el subtotal sumando todos los items
            $items = json_decode($request->items, true);
            $subtotal = 0;
            foreach ($items as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }

            // Calcular el coste de envío
            $costeEnvio = $subtotal >= self::ENVIO_GRATIS_MINIMO ? 0 : self::ENVIO_COSTE;
            
            // Calcular el total con IVA
            $totalSinIva = $subtotal + $costeEnvio;
            $iva = $totalSinIva * 0.21;
            $totalConIva = $totalSinIva + $iva;

            // Crear el pedido
            $pedido = Pedido::create([
                'user_id' => Auth::id(),
                'total' => $totalConIva,
                'subtotal' => $subtotal,
                'coste_envio' => $costeEnvio,
                'estado_id' => 1, // 1 = pendiente
                'direccion_envio' => $request->direccion_envio,
                'codigo_postal' => $request->codigo_postal,
                'ciudad' => $request->ciudad,
                'telefono' => $request->telefono,
                'metodo_pago' => 'Tarjeta terminada en ' . $ultimosDigitos,
            ]);

            // Crear los detalles del pedido
            $items = json_decode($request->items, true);
            foreach ($items as $item) {
                // Obtener el producto y verificar stock
                $producto = Producto::findOrFail($item['id']);
                
                if ($producto->stock < $item['quantity']) {
                    throw new \Exception("No hay suficiente stock para el producto: " . $producto->nombre);
                }

                // Restar el stock
                $producto->stock -= $item['quantity'];
                $producto->ventas += $item['quantity'];
                $producto->save();

                // Crear el detalle del pedido
                PedidoDetalle::create([
                    'pedido_id' => $pedido->id,
                    'producto_id' => $item['id'],
                    'cantidad' => $item['quantity'],
                    'precio_unitario' => $item['price'],
                    'subtotal' => $item['price'] * $item['quantity']
                ]);
            }

            // Generar la factura
            $this->facturaService->generarFactura($pedido);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pago procesado correctamente',
                'redirect' => route('checkout.success')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar el pago: ' . $e->getMessage()
            ], 500);
        }
    }

    public function success()
    {
        $pedido = Pedido::where('user_id', Auth::id())
            ->with(['detalles.producto', 'estado'])
            ->latest()
            ->first();

        if (!$pedido) {
            return redirect()->route('home')
                ->with('error', 'No se encontró el pedido');
        }

        return view('checkout.success', compact('pedido'));
    }
} 