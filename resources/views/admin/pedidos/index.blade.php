@extends('layouts.admin')

@section('content')
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-4 sm:p-6 text-gray-900 dark:text-gray-100">
        <div class="mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-[#1A323E] dark:text-white mb-2">Gestión de Pedidos</h1>
        </div>

        <!-- Contenedor para alertas -->
        <div id="alert-container"></div>

        <div class="overflow-x-auto -mx-4 sm:mx-0">
            <div class="inline-block min-w-full align-middle">
                <table id="pedidosTable" class="min-w-full bg-white dark:bg-gray-800 rounded-lg">
                    <thead>
                        <tr class="bg-[#F3C71E] bg-opacity-10">
                            <th class="px-6 py-4 border-b border-[#F3C71E] text-left text-xs font-semibold text-[#1A323E] dark:text-white uppercase tracking-wider">ID</th>
                            <th class="px-6 py-4 border-b border-[#F3C71E] text-left text-xs font-semibold text-[#1A323E] dark:text-white uppercase tracking-wider">Cliente</th>
                            <th class="px-6 py-4 border-b border-[#F3C71E] text-center text-xs font-semibold text-[#1A323E] dark:text-white uppercase tracking-wider">Fecha</th>
                            <th class="px-6 py-4 border-b border-[#F3C71E] text-center text-xs font-semibold text-[#1A323E] dark:text-white uppercase tracking-wider">Total</th>
                            <th class="px-6 py-4 border-b border-[#F3C71E] text-center text-xs font-semibold text-[#1A323E] dark:text-white uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-4 border-b border-[#F3C71E] text-center text-xs font-semibold text-[#1A323E] dark:text-white uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- El contenido se cargará dinámicamente con JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
        <div id="paginacion" class="mt-4">
            <!-- La paginación se cargará dinámicamente con JavaScript -->
        </div>
    </div>
</div>

<!-- Modal para ver detalles -->
<div id="modalDetalles" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="relative bg-white dark:bg-gray-800 w-full max-w-4xl rounded-lg shadow-xl">
            <div class="p-6">
                <div id="modalDetallesContenido">
                    <!-- El contenido se cargará dinámicamente con JavaScript -->
                </div>
                <div class="mt-4 flex justify-end">
                    <button onclick="cerrarModalDetalles()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js" defer></script>
<script src="{{ asset('js/admin/pedidos.js') }}" defer></script>
@endpush 