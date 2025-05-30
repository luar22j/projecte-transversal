@extends('layouts.app')

@section('title', 'Pago Exitoso')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="text-center mb-8">
                    <div class="mb-4">
                        <svg class="mx-auto h-16 w-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold mb-4">¡Pago Procesado con Éxito!</h2>
                    <p class="text-gray-600 mb-6">Tu pedido ha sido procesado correctamente. Recibirás un correo electrónico con los detalles de tu compra.</p>
                </div>

                <!-- Resumen del Pedido -->
                <div class="mt-8">
                    <h3 class="text-xl font-semibold mb-4">Resumen del Pedido #{{ $pedido->id }}</h3>
                    
                    <!-- Información del Pedido -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h4 class="text-lg font-medium mb-2">Información del Pedido</h4>
                            <p><strong>Fecha:</strong> {{ $pedido->created_at->format('d/m/Y H:i') }}</p>
                            <p><strong>Estado:</strong> 
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($pedido->estado->nombre === 'pendiente') bg-yellow-100 text-yellow-800
                                    @elseif($pedido->estado->nombre === 'enviado') bg-blue-100 text-blue-800
                                    @elseif($pedido->estado->nombre === 'entregado') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst($pedido->estado->nombre) }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <h4 class="text-lg font-medium mb-2">Dirección de Envío</h4>
                            <p>{{ $pedido->direccion_envio }}</p>
                            <p>{{ $pedido->codigo_postal }}</p>
                            <p>{{ $pedido->ciudad }}</p>
                            <p>{{ $pedido->telefono }}</p>
                        </div>
                    </div>

                    <!-- Productos -->
                    <div class="mt-6">
                        <h4 class="text-lg font-medium mb-4">Productos</h4>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio Unitario</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($pedido->detalles as $detalle)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $detalle->producto->nombre }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">€{{ number_format($detalle->precio_unitario, 2) }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $detalle->cantidad }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">€{{ number_format($detalle->subtotal, 2) }}</div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-gray-50">
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-right">Subtotal:</td>
                                        <td class="px-6 py-4 whitespace-nowrap">€{{ number_format($pedido->subtotal, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-right">Envío:</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $pedido->coste_envio == 0 ? 'Gratis' : '€' . number_format($pedido->coste_envio, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-right">IVA (21%):</td>
                                        <td class="px-6 py-4 whitespace-nowrap">€{{ number_format(($pedido->subtotal + $pedido->coste_envio) * 0.21, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-right font-bold">Total:</td>
                                        <td class="px-6 py-4 whitespace-nowrap font-bold">€{{ number_format($pedido->total, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="mt-8 flex justify-center space-x-4">
                        <a href="{{ route('cliente.pedidos.index') }}" class="inline-block bg-[#1A323E] text-white px-6 py-2 rounded-full hover:bg-[#2a4252] transition-colors">
                            Ver mis pedidos
                        </a>
                        <a href="{{ route('home') }}" class="inline-block text-[#1A323E] px-6 py-2 rounded-full hover:underline transition-all">
                            Volver al inicio
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection