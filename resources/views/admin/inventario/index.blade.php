@extends('layouts.admin')

@section('content')
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-4 sm:p-6 text-gray-900 dark:text-gray-100">
        <div class="mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-[#1A323E] dark:text-white mb-2">Gestión de Inventario - Productos Disponibles</h1>
            <div class="flex space-x-3">
                <a href="{{ route('admin.inventario.agotados') }}" class="inline-flex items-center px-4 py-2 bg-yellow-100 text-yellow-800 rounded-lg hover:bg-yellow-200 transition-colors">
                    <i class="fas fa-exclamation-triangle mr-2"></i> Productos Agotados
                </a>
                <a href="{{ route('admin.inventario.mas-vendidos') }}" class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-800 rounded-lg hover:bg-blue-200 transition-colors">
                    <i class="fas fa-chart-line mr-2"></i> Más Vendidos
                </a>
            </div>
        </div>

        <div class="bg-blue-50 dark:bg-blue-900/30 p-4 rounded-lg mb-6">
            <div class="flex items-center text-blue-800 dark:text-blue-400">
                <i class="fas fa-info-circle mr-2"></i>
                <p>En esta vista solo se muestran los productos con stock disponible. Para ver los productos agotados, haz clic en el botón "Productos Agotados".</p>
            </div>
        </div>

        <div class="overflow-x-auto -mx-4 sm:mx-0">
            <div class="inline-block min-w-full align-middle">
                <table class="min-w-full bg-white dark:bg-gray-800 rounded-lg" id="productosTable">
                    <thead>
                        <tr class="bg-[#F3C71E] bg-opacity-10">
                            <th class="px-6 py-4 border-b border-[#F3C71E] text-left text-xs font-semibold text-[#1A323E] dark:text-white uppercase tracking-wider">ID</th>
                            <th class="px-6 py-4 border-b border-[#F3C71E] text-left text-xs font-semibold text-[#1A323E] dark:text-white uppercase tracking-wider">Nombre</th>
                            <th class="px-6 py-4 border-b border-[#F3C71E] text-left text-xs font-semibold text-[#1A323E] dark:text-white uppercase tracking-wider">Categoría</th>
                            <th class="px-6 py-4 border-b border-[#F3C71E] text-center text-xs font-semibold text-[#1A323E] dark:text-white uppercase tracking-wider">Stock</th>
                            <th class="px-6 py-4 border-b border-[#F3C71E] text-center text-xs font-semibold text-[#1A323E] dark:text-white uppercase tracking-wider">Precio</th>
                            <th class="px-6 py-4 border-b border-[#F3C71E] text-center text-xs font-semibold text-[#1A323E] dark:text-white uppercase tracking-wider">Total Vendido</th>
                            <th class="px-6 py-4 border-b border-[#F3C71E] text-center text-xs font-semibold text-[#1A323E] dark:text-white uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Los datos se cargarán dinámicamente con JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
        <div id="paginacion" class="mt-4">
            <!-- La paginación se cargará dinámicamente con JavaScript -->
        </div>
    </div>
</div>

<!-- Modal para editar stock -->
<div id="editarStockModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="relative bg-white dark:bg-gray-800 w-full max-w-md rounded-lg shadow-xl">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h5 class="text-lg font-semibold text-[#1A323E] dark:text-white">Editar Stock</h5>
                    <button onclick="cerrarModalEditarStock()" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form id="editarStockForm" onsubmit="event.preventDefault(); guardarStock();">
                    <input type="hidden" id="producto_id" name="producto_id">
                    <div class="mb-4">
                        <label for="stock" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Nuevo Stock</label>
                        <input type="number" class="p-2 border-2 w-full rounded-lg bg-white dark:bg-gray-700 dark:text-white focus:border-[#F3C71E] focus:ring-[#F3C71E]" id="stock" name="stock" min="0" required>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="cerrarModalEditarStock()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">Cancelar</button>
                        <button type="submit" class="px-4 py-2 bg-[#F3C71E] text-[#1A323E] rounded-lg hover:bg-[#f4cf3c] transition-colors">Guardar</button>
                    </div>
                </form>
            </div>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js" defer></script>
<script src="{{ asset('js/admin/inventario.js') }}" defer></script>
@endpush 