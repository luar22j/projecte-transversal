<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detalle del Pedido #') . $pedido->id }}
            </h2>
            <a href="{{ route('cliente.pedidos.index') }}" class="text-blue-600 hover:text-blue-900">
                Volver a mis pedidos
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Información del Pedido</h3>
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
                            <p><strong>Total:</strong> €{{ number_format($pedido->total, 2) }}</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Dirección de Envío</h3>
                            <p>{{ $pedido->direccion }}</p>
                            <p>{{ $pedido->codigo_postal }}</p>
                            <p>{{ $pedido->ciudad }}</p>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h3 class="text-lg font-semibold mb-4">Productos</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($pedido->detalles as $detalle)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    @if($detalle->producto->imagen)
                                                        <img src="{{ asset('images/' . $detalle->producto->imagen) }}" alt="{{ $detalle->producto->nombre }}" class="w-10 rounded-full object-cover">
                                                    @endif
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $detalle->producto->nombre }}
                                                        </div>
                                                    </div>
                                                </div>
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
                            </table>
                        </div>
                    </div>

                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-2xl font-bold">Pedido #{{ $pedido->id }}</h2>
                        <div class="space-x-2">
                            <a href="{{ route('cliente.pedidos.factura', $pedido) }}" 
                               class="bg-[#F3C71E] hover:bg-[#1A323E] text-[#1A323E] font-bold py-2 px-4 rounded-full">
                                Descargar Factura
                            </a>
                            @if(in_array($pedido->estado, ['pendiente', 'en_proceso']))
                                <form action="{{ route('cliente.pedidos.cancelar', $pedido) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                            onclick="return confirm('¿Estás seguro de que deseas cancelar este pedido?')">
                                        Cancelar Pedido
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 