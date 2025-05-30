@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <h1 class="text-2xl font-bold text-[#1A323E] dark:text-white">Dashboard</h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Tarjeta de Usuarios -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-[#F3C71E] border-opacity-20">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-[#F3C71E] bg-opacity-10 text-[#1A323E] dark:text-white">
                    <i class="fas fa-users text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Usuarios</p>
                    <p class="text-lg font-semibold text-[#1A323E] dark:text-white">{{ $totalUsers ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Tarjeta de Productos -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-[#F3C71E] border-opacity-20">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-[#F3C71E] bg-opacity-10 text-[#1A323E] dark:text-white">
                    <i class="fas fa-box text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Productos</p>
                    <p class="text-lg font-semibold text-[#1A323E] dark:text-white">{{ $totalProducts ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Tarjeta de Pedidos -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-[#F3C71E] border-opacity-20">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-[#F3C71E] bg-opacity-10 text-[#1A323E] dark:text-white">
                    <i class="fas fa-shopping-cart text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Pedidos</p>
                    <p class="text-lg font-semibold text-[#1A323E] dark:text-white">{{ $totalOrders ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Tarjeta de Ingresos -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-[#F3C71E] border-opacity-20">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-[#F3C71E] bg-opacity-10 text-[#1A323E] dark:text-white">
                    <i class="fas fa-euro-sign text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Ingresos Totales</p>
                    <p class="text-lg font-semibold text-[#1A323E] dark:text-white">{{ number_format($totalRevenue ?? 0, 2) }}€</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos y Estadísticas -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Últimos Pedidos -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-[#F3C71E] border-opacity-20">
            <h2 class="text-lg font-semibold text-[#1A323E] dark:text-white mb-4">Últimos Pedidos</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-[#F3C71E] bg-opacity-10">
                            <th class="px-6 py-4 border-b border-[#F3C71E] text-left text-xs font-semibold text-[#1A323E] dark:text-white uppercase tracking-wider">ID</th>
                            <th class="px-6 py-4 border-b border-[#F3C71E] text-left text-xs font-semibold text-[#1A323E] dark:text-white uppercase tracking-wider">Cliente</th>
                            <th class="px-6 py-4 border-b border-[#F3C71E] text-left text-xs font-semibold text-[#1A323E] dark:text-white uppercase tracking-wider">Total</th>
                            <th class="px-6 py-4 border-b border-[#F3C71E] text-left text-xs font-semibold text-[#1A323E] dark:text-white uppercase tracking-wider">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($recentOrders ?? [] as $order)
                        <tr class="hover:bg-[#F3C71E] hover:bg-opacity-5 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-[#1A323E] dark:text-white">{{ $order->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-[#1A323E] dark:text-white">{{ $order->user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-[#1A323E] dark:text-white">{{ number_format($order->total, 2) }}€</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $order->estado === 'completado' ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400' : 'bg-[#F3C71E] bg-opacity-20 text-[#1A323E] dark:text-white' }}">
                                    {{ $order->estado }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-[#1A323E] dark:text-white">No hay pedidos recientes</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Productos más Vendidos -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-[#F3C71E] border-opacity-20">
            <h2 class="text-lg font-semibold text-[#1A323E] dark:text-white mb-4">Productos más Vendidos</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-[#F3C71E] bg-opacity-10">
                            <th class="px-6 py-4 border-b border-[#F3C71E] text-left text-xs font-semibold text-[#1A323E] dark:text-white uppercase tracking-wider">Producto</th>
                            <th class="px-6 py-4 border-b border-[#F3C71E] text-left text-xs font-semibold text-[#1A323E] dark:text-white uppercase tracking-wider">Categoría</th>
                            <th class="px-6 py-4 border-b border-[#F3C71E] text-left text-xs font-semibold text-[#1A323E] dark:text-white uppercase tracking-wider">Ventas</th>
                            <th class="px-6 py-4 border-b border-[#F3C71E] text-left text-xs font-semibold text-[#1A323E] dark:text-white uppercase tracking-wider">Stock</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($topProducts ?? [] as $product)
                        <tr class="hover:bg-[#F3C71E] hover:bg-opacity-5 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-[#1A323E] dark:text-white">{{ $product->nombre }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-[#1A323E] dark:text-white">
                                {{ $product->subcategoria?->categoria?->nombre ?? 'Sin categoría' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-[#1A323E] dark:text-white">{{ $product->ventas ?? 0 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $product->stock > 0 ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400' : 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400' }}">
                                    {{ $product->stock }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-[#1A323E] dark:text-white">No hay datos de productos</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
