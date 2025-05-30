@extends('layouts.admin')

@section('content')
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-4 sm:p-6 text-gray-900 dark:text-gray-100">
        <div class="mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-[#1A323E] dark:text-white mb-2">Crear Nuevo Descuento</h1>
            <div class="flex justify-end">
                <a href="{{ route('admin.descuentos.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-[#F3C71E] text-[#1A323E] rounded-lg hover:bg-[#f4cf3c] transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i> Volver a Descuentos
                </a>
            </div>
        </div>

        <div id="alert-container" class="mb-4"></div>

        <div class="max-w-2xl mx-auto">
            <form id="descuentoForm" action="{{ route('admin.descuentos.store') }}" method="POST">
                @csrf

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-[#F3C71E] border-opacity-20">
                    <div class="mb-6">
                        <label for="nombre" class="block text-sm font-semibold text-[#1A323E] dark:text-white mb-2">Nombre del Descuento</label>
                        <input type="text" 
                               name="nombre" 
                               id="nombre" 
                               class="w-full px-4 py-2 rounded-lg border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-[#1A323E] dark:text-white focus:border-[#F3C71E] focus:ring-[#F3C71E] transition-colors"
                               placeholder="Ej: Descuento de Verano"
                               required>
                        <div class="error-message text-red-600 dark:text-red-400 text-sm mt-2 hidden"></div>
                    </div>

                    <div class="mb-6">
                        <label for="descripcion" class="block text-sm font-semibold text-[#1A323E] dark:text-white mb-2">Descripción</label>
                        <textarea name="descripcion" 
                                  id="descripcion" 
                                  rows="3"
                                  class="w-full px-4 py-2 rounded-lg border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-[#1A323E] dark:text-white focus:border-[#F3C71E] focus:ring-[#F3C71E] transition-colors"
                                  placeholder="Describe el descuento..."></textarea>
                        <div class="error-message text-red-600 dark:text-red-400 text-sm mt-2 hidden"></div>
                    </div>

                    <div class="mb-6">
                        <label for="porcentaje" class="block text-sm font-semibold text-[#1A323E] dark:text-white mb-2">Porcentaje de Descuento</label>
                        <div class="relative">
                            <input type="number" 
                                   name="porcentaje" 
                                   id="porcentaje" 
                                   min="0"
                                   max="100"
                                   step="0.01"
                                   class="w-full px-4 py-2 rounded-lg border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-[#1A323E] dark:text-white focus:border-[#F3C71E] focus:ring-[#F3C71E] transition-colors"
                                   placeholder="0.00"
                                   required>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <span class="text-gray-500 dark:text-gray-400">%</span>
                            </div>
                        </div>
                        <div class="error-message text-red-600 dark:text-red-400 text-sm mt-2 hidden"></div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="fecha_inicio" class="block text-sm font-semibold text-[#1A323E] dark:text-white mb-2">Fecha de Inicio</label>
                            <input type="date" 
                                   name="fecha_inicio" 
                                   id="fecha_inicio" 
                                   class="w-full px-4 py-2 rounded-lg border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-[#1A323E] dark:text-white focus:border-[#F3C71E] focus:ring-[#F3C71E] transition-colors"
                                   required>
                            <div class="error-message text-red-600 dark:text-red-400 text-sm mt-2 hidden"></div>
                        </div>

                        <div>
                            <label for="fecha_fin" class="block text-sm font-semibold text-[#1A323E] dark:text-white mb-2">Fecha de Fin</label>
                            <input type="date" 
                                   name="fecha_fin" 
                                   id="fecha_fin" 
                                   class="w-full px-4 py-2 rounded-lg border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-[#1A323E] dark:text-white focus:border-[#F3C71E] focus:ring-[#F3C71E] transition-colors"
                                   required>
                            <div class="error-message text-red-600 dark:text-red-400 text-sm mt-2 hidden"></div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-[#1A323E] dark:text-white mb-2">Productos Aplicables</label>
                        <div class="bg-gray-50 dark:bg-gray-900 rounded-lg border-2 border-gray-200 dark:border-gray-700 p-4 max-h-60 overflow-y-auto">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="productos-container">
                                <!-- Los productos se cargarán dinámicamente con JavaScript -->
                            </div>
                        </div>
                        <div class="error-message text-red-600 dark:text-red-400 text-sm mt-2 hidden"></div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-3 bg-[#F3C71E] text-[#1A323E] rounded-lg hover:bg-[#f4cf3c] transition-colors font-semibold">
                            <i class="fas fa-plus mr-2"></i> Crear Descuento
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script defer>
document.addEventListener('DOMContentLoaded', async () => {
    const container = document.getElementById('productos-container');
    const alertContainer = document.getElementById('alert-container');

    try {
        const response = await fetch('/admin/productos', {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (!response.ok) {
            throw new Error('Error al cargar los productos');
        }

        const data = await response.json();
        
        if (!data.data || !Array.isArray(data.data)) {
            throw new Error('Formato de datos inválido');
        }

        container.innerHTML = data.data.map(producto => `
            <div class="flex items-center space-x-3 p-2 rounded-lg hover:bg-[#F3C71E] hover:bg-opacity-10 transition-colors">
                <input type="checkbox" 
                       name="productos[]" 
                       value="${producto.id}"
                       id="producto_${producto.id}"
                       class="w-4 h-4 rounded border-gray-300 text-[#F3C71E] focus:ring-[#F3C71E]">
                <label for="producto_${producto.id}" class="text-sm text-[#1A323E] dark:text-white">
                    ${producto.nombre}
                </label>
            </div>
        `).join('');

        // Configurar el formulario
        const form = document.getElementById('descuentoForm');
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());
            data.productos = Array.from(formData.getAll('productos[]')).map(Number);

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (!response.ok) {
                    throw new Error(result.message || 'Error al crear el descuento');
                }

                showAlert('Descuento creado exitosamente', 'success');
                setTimeout(() => window.location.href = '/admin/descuentos', 1500);
            } catch (error) {
                showAlert(error.message, 'error');
            }
        });
    } catch (error) {
        console.error('Error:', error);
        showAlert(error.message, 'error');
        container.innerHTML = '<div class="text-red-600 dark:text-red-400">Error al cargar los productos. Por favor, recarga la página.</div>';
    }
});

function showAlert(message, type) {
    const container = document.getElementById('alert-container');
    const alert = document.createElement('div');
    alert.className = `p-4 mb-4 rounded-lg ${type === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'}`;
    alert.textContent = message;
    container.appendChild(alert);
    setTimeout(() => alert.remove(), 3000);
}
</script>
@endpush
@endsection 