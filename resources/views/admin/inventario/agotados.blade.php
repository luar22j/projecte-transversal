@extends('layouts.admin')

@section('content')
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-4 sm:p-6 text-gray-900 dark:text-gray-100">
        <div class="mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-[#1A323E] dark:text-white mb-2">Productos Agotados</h1>
            <div class="flex justify-end">
                <a href="{{ route('admin.inventario.index') }}" class="inline-flex items-center px-4 py-2 bg-[#F3C71E] text-[#1A323E] rounded-lg hover:bg-[#f4cf3c] transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i> Volver al Inventario
                </a>
            </div>
        </div>

        <div class="overflow-x-auto -mx-4 sm:mx-0">
            <div class="inline-block min-w-full align-middle">
                <table class="min-w-full bg-white dark:bg-gray-800 rounded-lg">
                    <thead>
                        <tr class="bg-[#F3C71E] bg-opacity-10">
                            <th class="px-6 py-4 border-b border-[#F3C71E] text-left text-xs font-semibold text-[#1A323E] dark:text-white uppercase tracking-wider">ID</th>
                            <th class="px-6 py-4 border-b border-[#F3C71E] text-left text-xs font-semibold text-[#1A323E] dark:text-white uppercase tracking-wider">Nombre</th>
                            <th class="px-6 py-4 border-b border-[#F3C71E] text-left text-xs font-semibold text-[#1A323E] dark:text-white uppercase tracking-wider">Categoría</th>
                            <th class="px-6 py-4 border-b border-[#F3C71E] text-center text-xs font-semibold text-[#1A323E] dark:text-white uppercase tracking-wider">Total Vendido</th>
                            <th class="px-6 py-4 border-b border-[#F3C71E] text-center text-xs font-semibold text-[#1A323E] dark:text-white uppercase tracking-wider">Última Venta</th>
                            <th class="px-6 py-4 border-b border-[#F3C71E] text-center text-xs font-semibold text-[#1A323E] dark:text-white uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($productos as $producto)
                        <tr class="hover:bg-[#F3C71E] hover:bg-opacity-5 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200 dark:border-gray-700 text-sm">{{ $producto->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200 dark:border-gray-700 text-sm">{{ $producto->nombre }}</td>
                            <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200 dark:border-gray-700 text-sm">
                                {{ $producto->categoria_nombre }}
                                @if($producto->subcategoria)
                                    > {{ $producto->subcategoria->nombre }}
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200 dark:border-gray-700 text-sm text-center">{{ $producto->total_vendido }}</td>
                            <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200 dark:border-gray-700 text-sm text-center">
                                {{ $producto->pedidos->last()?->created_at?->format('d/m/Y H:i') ?? 'Nunca' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200 dark:border-gray-700 text-sm text-center">
                                <button type="button" class="inline-flex items-center px-3 py-1.5 bg-[#F3C71E] text-[#1A323E] rounded-lg hover:bg-[#f4cf3c] transition-colors" 
                                        onclick="editarStock({{ $producto->id }}, {{ $producto->stock }})">
                                    <i class="fas fa-edit mr-1"></i> Reponer Stock
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-4">
            {{ $productos->links() }}
        </div>
    </div>
</div>

<!-- Modal para editar stock -->
<div class="modal fade" id="editarStockModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content bg-white rounded-lg shadow-xl">
            <div class="modal-header p-4 border-b border-gray-200">
                <h5 class="modal-title text-lg font-semibold text-[#1A323E]">Reponer Stock</h5>
                <button type="button" class="close text-gray-500 hover:text-gray-700" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <form id="editarStockForm">
                    <input type="hidden" id="producto_id" name="producto_id">
                    <div class="form-group">
                        <label for="stock" class="block text-sm font-semibold text-gray-700 mb-2">Cantidad a Reponer</label>
                        <input type="number" class="p-2 border-2 w-full rounded-lg bg-white focus:border-[#F3C71E] focus:ring-[#F3C71E]" id="stock" name="stock" min="1" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer p-4 border-t border-gray-200 flex justify-end space-x-3">
                <button type="button" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors" data-dismiss="modal">Cancelar</button>
                <button type="button" class="px-4 py-2 bg-[#F3C71E] text-[#1A323E] rounded-lg hover:bg-[#f4cf3c] transition-colors" onclick="guardarStock()">Guardar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script defer>
function editarStock(id, stockActual) {
    $('#producto_id').val(id);
    $('#stock').val(1); // Por defecto, sugerir reponer 1 unidad
    $('#editarStockModal').modal('show');
}

function guardarStock() {
    const id = $('#producto_id').val();
    const stock = $('#stock').val();

    $.ajax({
        url: `/admin/inventario/${id}/stock`,
        method: 'PUT',
        data: { stock },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            $('#editarStockModal').modal('hide');
            location.reload();
        },
        error: function(error) {
            alert('Error al actualizar el stock');
        }
    });
}
</script>
@endpush 