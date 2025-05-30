@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-[#1A323E] dark:text-white">Editar Producto</h1>
            <a href="{{ route('admin.productos.index') }}" 
               class="text-[#1A323E] dark:text-white hover:text-[#2A4250]">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <form action="{{ route('admin.productos.update', $producto) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                    <input type="text" 
                           name="nombre" 
                           id="nombre" 
                           value="{{ old('nombre', $producto->nombre) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-[#F3C71E] focus:ring focus:ring-[#F3C71E] focus:ring-opacity-50"
                           required>
                    @error('nombre')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="descripcion" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descripción</label>
                    <textarea name="descripcion" 
                              id="descripcion" 
                              rows="3"
                              class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-[#F3C71E] focus:ring focus:ring-[#F3C71E] focus:ring-opacity-50"
                              required>{{ old('descripcion', $producto->descripcion) }}</textarea>
                    @error('descripcion')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="precio" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Precio</label>
                        <input type="number" 
                               name="precio" 
                               id="precio" 
                               value="{{ old('precio', $producto->precio) }}"
                               step="0.01"
                               min="0"
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-[#F3C71E] focus:ring focus:ring-[#F3C71E] focus:ring-opacity-50"
                               required>
                        @error('precio')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="stock" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Stock</label>
                        <input type="number" 
                               name="stock" 
                               id="stock" 
                               value="{{ old('stock', $producto->stock) }}"
                               min="0"
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-[#F3C71E] focus:ring focus:ring-[#F3C71E] focus:ring-opacity-50"
                               required>
                        @error('stock')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="categoria_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Categoría</label>
                    <select name="categoria_id" 
                            id="categoria_id"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-[#F3C71E] focus:ring focus:ring-[#F3C71E] focus:ring-opacity-50"
                            required>
                        <option value="">Seleccione una categoría</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}" 
                                    {{ old('categoria_id', $producto->categoria_id) == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('categoria_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="subcategoria_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Subcategoría</label>
                    <select name="subcategoria_id" 
                            id="subcategoria_id"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-[#F3C71E] focus:ring focus:ring-[#F3C71E] focus:ring-opacity-50"
                            required>
                        <option value="">Seleccione una subcategoría</option>
                        @foreach($subcategorias as $subcategoria)
                            <option value="{{ $subcategoria->id }}" 
                                    data-categoria-id="{{ $subcategoria->categoria_id }}"
                                    {{ old('subcategoria_id', $producto->subcategoria_id) == $subcategoria->id ? 'selected' : '' }}>
                                {{ $subcategoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('subcategoria_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="imagen" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Imagen</label>
                    @if($producto->imagen)
                        <div class="mt-2 mb-4">
                            <img src="{{ asset('images/' . $producto->imagen) }}" 
                                 alt="{{ $producto->nombre }}" 
                                 class="w-32 object-cover rounded-lg">
                        </div>
                    @endif
                    <input type="file" 
                           name="imagen" 
                           id="imagen"
                           accept="image/*"
                           class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-full file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-[#F3C71E] file:text-[#1A323E]
                                  hover:file:bg-[#E5B800]">
                    @error('imagen')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" 
                            class="bg-[#F3C71E] text-[#1A323E] px-4 py-2 rounded-lg hover:bg-[#E5B800] transition-colors">
                        Actualizar Producto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script defer>
document.addEventListener('DOMContentLoaded', function() {
    const categoriaSelect = document.getElementById('categoria_id');
    const subcategoriaSelect = document.getElementById('subcategoria_id');
    const subcategoriaOptions = Array.from(subcategoriaSelect.options);

    function actualizarSubcategorias() {
        const categoriaId = categoriaSelect.value;
        
        // Ocultar todas las opciones primero
        subcategoriaOptions.forEach(option => {
            if (option.value === '') {
                option.style.display = ''; // Mostrar la opción por defecto
            } else {
                option.style.display = option.dataset.categoriaId === categoriaId ? '' : 'none';
            }
        });

        // Si la subcategoría seleccionada no pertenece a la categoría seleccionada, resetearla
        const selectedOption = subcategoriaSelect.options[subcategoriaSelect.selectedIndex];
        if (selectedOption && selectedOption.dataset.categoriaId !== categoriaId) {
            subcategoriaSelect.value = '';
        }
    }

    categoriaSelect.addEventListener('change', actualizarSubcategorias);

    // Ejecutar al cargar la página
    actualizarSubcategorias();
});
</script>
@endpush
@endsection 