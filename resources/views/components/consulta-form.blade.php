@props(['producto' => null])

<div class="max-w-2xl mx-auto p-8 bg-white rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold mb-8 text-gray-800 text-center">Consulta sobre Producto</h2>
    
    <form id="consultaForm" class="space-y-6">
        @csrf
        
        @guest
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nombre" class="block text-sm font-semibold text-gray-700 mb-2">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-white text-gray-900 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-colors">
                    <span class="text-red-500 text-sm hidden mt-1" id="nombreError"></span>
                </div>
                
                <div>
                    <label for="apellidos" class="block text-sm font-semibold text-gray-700 mb-2">Apellidos</label>
                    <input type="text" name="apellidos" id="apellidos" class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-white text-gray-900 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-colors">
                    <span class="text-red-500 text-sm hidden mt-1" id="apellidosError"></span>
                </div>
            </div>

            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                <input type="email" name="email" id="email" class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-white text-gray-900 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-colors">
                <span class="text-red-500 text-sm hidden mt-1" id="emailError"></span>
            </div>
        @endguest

        <div>
            <label for="producto" class="block text-sm font-semibold text-gray-700 mb-2">Producto</label>
            <input type="text" name="producto" id="producto" value="{{ $producto }}" class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-white text-gray-900 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-colors">
            <span class="text-red-500 text-sm hidden mt-1" id="productoError"></span>
        </div>

        <div>
            <label for="consulta" class="block text-sm font-semibold text-gray-700 mb-2">Consulta</label>
            <textarea name="consulta" id="consulta" rows="4" maxlength="150" class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-white text-gray-900 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-colors resize-none"></textarea>
            <div class="flex justify-between mt-2">
                <span class="text-red-500 text-sm hidden" id="consultaError"></span>
                <span class="text-sm text-gray-500"><span id="charCount">0</span>/150</span>
            </div>
        </div>

        <div class="flex justify-end pt-4">
            <button type="submit" id="submitBtn" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg bg-[#F3C71E] text-[#1A323E] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary disabled:opacity-50 disabled:cursor-not-allowed shadow-sm transition-colors">
                <span class="hidden" id="spinner">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-gray-900" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </span>
                Enviar Consulta
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script defer>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('consultaForm');
    const submitBtn = document.getElementById('submitBtn');
    const spinner = document.getElementById('spinner');
    const charCount = document.getElementById('charCount');
    const consultaTextarea = document.getElementById('consulta');
    
    // Contador de caracteres
    consultaTextarea.addEventListener('input', function() {
        const length = this.value.length;
        charCount.textContent = length;
    });

    // Validación en tiempo real
    const inputs = form.querySelectorAll('input, textarea');
    inputs.forEach(input => {
        input.addEventListener('input', validateForm);
    });

    function validateForm() {
        let isValid = true;
        inputs.forEach(input => {
            if (!input.value.trim()) {
                isValid = false;
            }
        });
        submitBtn.disabled = !isValid;
    }

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // Mostrar spinner
        spinner.classList.remove('hidden');
        submitBtn.disabled = true;

        try {
            const response = await fetch('{{ route("contact.send") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    nombre: document.getElementById('nombre')?.value,
                    apellidos: document.getElementById('apellidos')?.value,
                    email: document.getElementById('email')?.value,
                    producto: document.getElementById('producto').value,
                    consulta: document.getElementById('consulta').value
                })
            });

            const data = await response.json();

            if (!response.ok) {
                throw data;
            }

            // Limpiar errores
            document.querySelectorAll('[id$="Error"]').forEach(el => {
                el.classList.add('hidden');
                el.textContent = '';
            });

            // Mostrar mensaje de éxito
            alert('Consulta enviada correctamente');
            form.reset();
            charCount.textContent = '0';

        } catch (error) {
            // Mostrar errores
            if (error.errors) {
                Object.keys(error.errors).forEach(key => {
                    const errorElement = document.getElementById(key + 'Error');
                    if (errorElement) {
                        errorElement.textContent = error.errors[key][0];
                        errorElement.classList.remove('hidden');
                    }
                });
            }
        } finally {
            // Ocultar spinner
            spinner.classList.add('hidden');
            submitBtn.disabled = false;
            validateForm();
        }
    });

    // Validación inicial
    validateForm();
});
</script>
@endpush 