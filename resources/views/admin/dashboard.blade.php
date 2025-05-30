@extends('layouts.admin')

@section('content')
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-4 sm:p-6 text-gray-900 dark:text-gray-100">
        <div class="mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-[#1A323E] dark:text-white mb-2">Panel de Administración</h1>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6 sm:mb-8">
            <div class="bg-[#F3C71E] bg-opacity-10 p-4 sm:p-6 rounded-lg border border-[#F3C71E]">
                <h3 class="text-base sm:text-lg font-semibold text-[#1A323E] dark:text-white">Total Usuarios</h3>
                <p class="text-2xl sm:text-3xl font-bold text-[#F3C71E]" id="totalUsers">Cargando...</p>
            </div>
            <div class="bg-[#F3C71E] bg-opacity-10 p-4 sm:p-6 rounded-lg border border-[#F3C71E]">
                <h3 class="text-base sm:text-lg font-semibold text-[#1A323E] dark:text-white">Total Pedidos</h3>
                <p class="text-2xl sm:text-3xl font-bold text-[#F3C71E]" id="totalPedidos">Cargando...</p>
            </div>
            <div class="bg-[#F3C71E] bg-opacity-10 p-4 sm:p-6 rounded-lg border border-[#F3C71E]">
                <h3 class="text-base sm:text-lg font-semibold text-[#1A323E] dark:text-white">Total Productos</h3>
                <p class="text-2xl sm:text-3xl font-bold text-[#F3C71E]" id="totalProductos">Cargando...</p>
            </div>
        </div>

        <div class="mt-6 sm:mt-8">
            <h3 class="text-lg font-semibold mb-4 text-[#1A323E] dark:text-white">Pedidos Recientes</h3>
            <div class="overflow-x-auto -mx-4 sm:mx-0">
                <div class="inline-block min-w-full align-middle">
                    <table class="min-w-full bg-white dark:bg-gray-800 rounded-lg">
                        <thead>
                            <tr class="bg-[#F3C71E] bg-opacity-10">
                                <th class="px-3 sm:px-6 py-3 border-b-2 border-[#F3C71E] text-left text-xs font-semibold text-[#1A323E] dark:text-white uppercase tracking-wider">
                                    ID
                                </th>
                                <th class="px-3 sm:px-6 py-3 border-b-2 border-[#F3C71E] text-left text-xs font-semibold text-[#1A323E] dark:text-white uppercase tracking-wider">
                                    Cliente
                                </th>
                                <th class="px-3 sm:px-6 py-3 border-b-2 border-[#F3C71E] text-left text-xs font-semibold text-[#1A323E] dark:text-white uppercase tracking-wider">
                                    Total
                                </th>
                                <th class="px-3 sm:px-6 py-3 border-b-2 border-[#F3C71E] text-left text-xs font-semibold text-[#1A323E] dark:text-white uppercase tracking-wider">
                                    Estado
                                </th>
                                <th class="px-3 sm:px-6 py-3 border-b-2 border-[#F3C71E] text-left text-xs font-semibold text-[#1A323E] dark:text-white uppercase tracking-wider">
                                    Fecha
                                </th>
                            </tr>
                        </thead>
                        <tbody id="recentOrdersTable">
                            <tr>
                                <td colspan="5" class="px-3 sm:px-6 py-3 text-center">Cargando...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-6 sm:mt-8">
            <h3 class="text-lg font-semibold mb-4 text-[#1A323E] dark:text-white">Productos más Vendidos</h3>
            <div class="overflow-x-auto -mx-4 sm:mx-0">
                <div class="inline-block min-w-full align-middle">
                    <table class="min-w-full bg-white dark:bg-gray-800 rounded-lg">
                        <thead>
                            <tr class="bg-[#F3C71E] bg-opacity-10">
                                <th class="px-3 sm:px-6 py-3 border-b-2 border-[#F3C71E] text-left text-xs font-semibold text-[#1A323E] dark:text-white uppercase tracking-wider">
                                    Producto
                                </th>
                                <th class="px-3 sm:px-6 py-3 border-b-2 border-[#F3C71E] text-left text-xs font-semibold text-[#1A323E] dark:text-white uppercase tracking-wider">
                                    Categoría
                                </th>
                                <th class="px-3 sm:px-6 py-3 border-b-2 border-[#F3C71E] text-left text-xs font-semibold text-[#1A323E] dark:text-white uppercase tracking-wider">
                                    Ventas
                                </th>
                                <th class="px-3 sm:px-6 py-3 border-b-2 border-[#F3C71E] text-left text-xs font-semibold text-[#1A323E] dark:text-white uppercase tracking-wider">
                                    Stock
                                </th>
                                <th class="px-3 sm:px-6 py-3 border-b-2 border-[#F3C71E] text-left text-xs font-semibold text-[#1A323E] dark:text-white uppercase tracking-wider">
                                    Estado
                                </th>
                            </tr>
                        </thead>
                        <tbody id="topProductsTable">
                            <tr>
                                <td colspan="5" class="px-3 sm:px-6 py-3 text-center">Cargando...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script defer>
document.addEventListener('DOMContentLoaded', function() {
    // Función para cargar los datos del dashboard
    async function loadDashboardData() {
        try {
            const response = await fetch('{{ route("admin.dashboard.data") }}');
            const data = await response.json();

            // Actualizar contadores
            document.getElementById('totalUsers').textContent = data.totalUsers;
            document.getElementById('totalPedidos').textContent = data.totalPedidos;
            document.getElementById('totalProductos').textContent = data.totalProductos;

            // Actualizar tabla de pedidos recientes
            const recentOrdersTable = document.getElementById('recentOrdersTable');
            recentOrdersTable.innerHTML = data.recentOrders.map(pedido => `
                <tr class="hover:bg-[#F3C71E] hover:bg-opacity-5 transition-colors">
                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap border-b border-gray-200 dark:border-gray-700 text-sm">
                        ${pedido.id}
                    </td>
                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap border-b border-gray-200 dark:border-gray-700 text-sm">
                        ${pedido.cliente}
                    </td>
                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap border-b border-gray-200 dark:border-gray-700 text-sm">
                        ${pedido.total}€
                    </td>
                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap border-b border-gray-200 dark:border-gray-700 text-sm">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${getEstadoClass(pedido.estado)}">
                            ${pedido.estado.charAt(0).toUpperCase() + pedido.estado.slice(1)}
                        </span>
                    </td>
                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap border-b border-gray-200 dark:border-gray-700 text-sm">
                        ${pedido.fecha}
                    </td>
                </tr>
            `).join('');

            // Actualizar tabla de productos más vendidos
            const topProductsTable = document.getElementById('topProductsTable');
            topProductsTable.innerHTML = data.topProducts.map(producto => `
                <tr class="hover:bg-[#F3C71E] hover:bg-opacity-5 transition-colors">
                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap border-b border-gray-200 dark:border-gray-700 text-sm">
                        ${producto.nombre}
                    </td>
                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap border-b border-gray-200 dark:border-gray-700 text-sm">
                        ${producto.categoria}
                    </td>
                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap border-b border-gray-200 dark:border-gray-700 text-sm">
                        ${producto.ventas}
                    </td>
                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap border-b border-gray-200 dark:border-gray-700 text-sm">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${getStockClass(producto.stock)}">
                            ${producto.stock}
                        </span>
                    </td>
                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap border-b border-gray-200 dark:border-gray-700 text-sm">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${getEstadoClass(producto.estado)}">
                            ${producto.estado}
                        </span>
                    </td>
                </tr>
            `).join('');

        } catch (error) {
            console.error('Error al cargar los datos del dashboard:', error);
        }
    }

    // Función para obtener la clase CSS según el estado
    function getEstadoClass(estado) {
        switch(estado.toLowerCase()) {
            case 'pendiente':
                return 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300';
            case 'en_proceso':
                return 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300';
            case 'enviado':
                return 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300';
            case 'entregado':
                return 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300';
            case 'disponible':
                return 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300';
            case 'sin stock':
                return 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300';
            default:
                return 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300';
        }
    }

    // Función para obtener la clase CSS según el stock
    function getStockClass(stock) {
        if (stock > 5) {
            return 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400';
        } else if (stock > 0) {
            return 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400';
        } else {
            return 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400';
        }
    }

    // Cargar datos iniciales
    loadDashboardData();

    // Recargar datos cada 30 segundos
    setInterval(loadDashboardData, 30000);
});
</script>
@endpush
@endsection 