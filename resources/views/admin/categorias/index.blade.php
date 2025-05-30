@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-[#1A323E] dark:text-white">Gestión de Categorías</h1>
        <a href="{{ route('admin.categorias.create') }}" 
           class="bg-[#F3C71E] hover:bg-opacity-90 text-[#1A323E] font-bold py-2 px-4 rounded transition-colors">
            <i class="fas fa-plus mr-2"></i>Nueva Categoría
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Imagen</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Descripción</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Subcategorías</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($categorias as $categoria)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">
                                {{ $categoria->id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($categoria->imagen)
                                    <img src="{{ Storage::url($categoria->imagen) }}" 
                                         alt="{{ $categoria->nombre }}" 
                                         class="h-12 w-12 object-cover rounded-full">
                                @else
                                    <div class="h-12 w-12 bg-gray-200 rounded-full flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">
                                {{ $categoria->nombre }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">
                                {{ Str::limit($categoria->descripcion, 50) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-900 dark:text-gray-300">
                                {{ $categoria->subcategorias_count }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('admin.categorias.edit', $categoria) }}" 
                                       class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="confirmarEliminacion({{ $categoria->id }})" 
                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $categorias->links() }}
    </div>
</div>

@push('scripts')
<script defer>
function confirmarEliminacion(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción no se puede deshacer",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            eliminarCategoria(id);
        }
    });
}

async function eliminarCategoria(id) {
    try {
        const response = await fetch(`/admin/categorias/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (response.ok) {
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: 'Categoría eliminada correctamente',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                window.location.reload();
            });
        } else {
            throw new Error(data.message || 'Error al eliminar la categoría');
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.message
        });
    }
}
</script>
@endpush
@endsection 