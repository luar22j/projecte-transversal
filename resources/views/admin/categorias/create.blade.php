@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-[#1A323E] dark:text-white">Crear Nueva Categoría</h1>
            <a href="{{ route('admin.categorias.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Volver
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
            <form action="{{ route('admin.categorias.store') }}" method="POST" enctype="multipart/form-data" id="createCategoryForm">
                @csrf
                
                <div class="mb-4">
                    <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Nombre de la Categoría
                    </label>
                    <input type="text" 
                           name="nombre" 
                           id="nombre" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#F3C71E] focus:border-[#F3C71E] dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                           required>
                </div>

                <div class="mb-4">
                    <label for="descripcion" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Descripción
                    </label>
                    <textarea name="descripcion" 
                              id="descripcion" 
                              rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#F3C71E] focus:border-[#F3C71E] dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
                </div>

                <div class="mb-6">
                    <label for="imagen" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Imagen de la Categoría
                    </label>
                    <input type="file" 
                           name="imagen" 
                           id="imagen" 
                           accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#F3C71E] focus:border-[#F3C71E] dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Formatos permitidos: JPEG, PNG, JPG, GIF. Tamaño máximo: 2MB
                    </p>
                </div>

                <div class="flex justify-end">
                    <button type="submit" 
                            class="bg-[#F3C71E] hover:bg-opacity-90 text-[#1A323E] font-bold py-2 px-4 rounded transition-colors">
                        <i class="fas fa-save mr-2"></i>Guardar Categoría
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script defer>
document.getElementById('createCategoryForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    try {
        const response = await fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        const data = await response.json();
        
        if (response.ok) {
            // Mostrar mensaje de éxito
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: 'Categoría creada correctamente',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                window.location.href = '{{ route("admin.categorias.index") }}';
            });
        } else {
            throw new Error(data.message || 'Error al crear la categoría');
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.message
        });
    }
});
</script>
@endpush
@endsection 