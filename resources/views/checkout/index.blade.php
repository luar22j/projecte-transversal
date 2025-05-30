@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
@auth
<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h2 class="text-2xl font-bold mb-6">Finalizar Compra</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Resumen del pedido -->
                    <div class="bg-[#1A323E] p-6 rounded-lg">
                        <h3 class="text-xl font-semibold mb-4 text-white">Resumen del Pedido</h3>
                        <div id="cart-items">
                            <!-- Los items del carrito se cargarán aquí dinámicamente -->
                        </div>
                    </div>

                    <!-- Formulario de pago y envío -->
                    <div class="space-y-6">
                        <!-- Información de envío -->
                        <div class="bg-[#1A323E] p-6 rounded-lg">
                            <h3 class="text-xl font-semibold mb-4 text-white">Información de Envío</h3>
                            
                            <div class="mb-4">
                                <label class="block text-white text-sm font-bold mb-2" for="direccion_envio">
                                    Dirección de envío
                                </label>
                                <input class="bg-white shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                       id="direccion_envio" 
                                       type="text" 
                                       name="direccion_envio" 
                                       value="{{ $user->direccion_envio ?? '' }}"
                                       required>
                                <div id="direccion_envio-error" class="error-message"></div>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-white text-sm font-bold mb-2" for="codigo_postal">
                                        Código Postal
                                    </label>
                                    <input class="bg-white shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                           id="codigo_postal" 
                                           type="text" 
                                           name="codigo_postal"
                                           value="{{ $user->codigo_postal ?? '' }}"
                                           maxlength="5"
                                           pattern="[0-9]{5}"
                                           required>
                                    <div id="codigo_postal-error" class="error-message"></div>
                                </div>
                                <div>
                                    <label class="block text-white text-sm font-bold mb-2" for="ciudad">
                                        Ciudad
                                    </label>
                                    <input class="bg-white shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                           id="ciudad" 
                                           type="text" 
                                           name="ciudad"
                                           value="{{ $user->ciudad ?? '' }}"
                                           required>
                                    <div id="ciudad-error" class="error-message"></div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="block text-white text-sm font-bold mb-2" for="telefono">
                                    Teléfono
                                </label>
                                <input class="bg-white shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                       id="telefono" 
                                       type="text" 
                                       name="telefono"
                                       value="{{ $user->telefono ?? '' }}"
                                       required>
                                <div id="telefono-error" class="error-message"></div>
                            </div>
                        </div>

                        <!-- Formulario de pago -->
                        <div class="bg-[#1A323E] p-6 rounded-lg">
                            <h3 class="text-xl font-semibold mb-4 text-white">Información de Pago</h3>
                            
                            <form id="payment-form" action="{{ route('checkout.store') }}" method="POST">
                                @csrf
                                
                                <div class="mb-4">
                                    <label class="block text-white text-sm font-bold mb-2" for="nombre">
                                        Nombre en la tarjeta
                                    </label>
                                    <input class="bg-white shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                           id="nombre" 
                                           type="text" 
                                           name="nombre"
                                           required>
                                    <div id="nombre-error" class="error-message"></div>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-white text-sm font-bold mb-2" for="numero">
                                        Número de tarjeta
                                    </label>
                                    <input class="bg-white shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                           id="numero" 
                                           type="text" 
                                           name="numero"
                                           maxlength="16"
                                           pattern="[0-9]{16}"
                                           required>
                                    <div id="numero-error" class="error-message"></div>
                                </div>

                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label class="block text-white text-sm font-bold mb-2" for="expiracion">
                                            Fecha de expiración
                                        </label>
                                        <input class="bg-white shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                               id="expiracion" 
                                               type="text" 
                                               name="expiracion"
                                               placeholder="MM/YY"
                                               maxlength="5"
                                               pattern="(0[1-9]|1[0-2])/([0-9]{2})"
                                               required>
                                               <div id="expiracion-error" class="error-message"></div>
                                    </div>
                                    <div>
                                        <label class="block text-white text-sm font-bold mb-2" for="cvv">
                                            CVV
                                        </label>
                                        <input class="bg-white shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                               id="cvv" 
                                               type="text" 
                                               name="cvv"
                                               maxlength="3"
                                               pattern="[0-9]{3}"
                                               required>
                                               <div id="cvv-error" class="error-message"></div>
                                    </div>
                                </div>

                                <button class="w-full bg-[#F3C71E] text-[#1A323E] font-bold py-2 px-4 rounded-full hover:bg-[#f4cf3c] focus:outline-none focus:shadow-outline transition-all" 
                                        type="submit">
                                    Pagar <span id="payment-amount">€0.00</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-center">
                <h2 class="text-2xl font-bold mb-4 text-[#1A323E]">Necesitas iniciar sesión</h2>
                <p class="text-gray-600 mb-6">Para proceder con el pago, necesitas tener una cuenta.</p>
                <div class="space-x-4">
                    <a href="{{ route('login') }}" class="bg-[#F3C71E] hover:bg-[#f4cf3c] text-[#1A323E] font-bold py-2 px-4 rounded-full transition-colors">
                        Iniciar Sesión
                    </a>
                    <a href="{{ route('register') }}" class="bg-[#1A323E] hover:bg-[#2a4252] text-white font-bold py-2 px-4 rounded-full transition-colors">
                        Registrarse
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endauth
@endsection

@push('styles')
<style>
    .error-message {
        color: #ef4444;
        font-size: 12px;
    }
</style>
@endpush

@push('scripts')
<script defer>
document.addEventListener('DOMContentLoaded', function() {
    // Cargar items del carrito desde localStorage
    const cartItems = document.getElementById('cart-items');
    let total = 0;
    
    // Limpiar el contenedor antes de agregar nuevos items
    cartItems.innerHTML = '';
    
    // Obtener el carrito del localStorage usando la key correcta 'cart'
    const carritoStr = localStorage.getItem('cart');
    
    const carrito = JSON.parse(carritoStr) || [];
    
    if (carrito && carrito.length > 0) {        
        carrito.forEach((item, index) => {
            const itemTotal = parseFloat(item.price) * parseInt(item.quantity);
            total += itemTotal;
            
            cartItems.innerHTML += `
                <div class="flex justify-between items-center border-b border-gray-700 pb-4" data-id="${item.id}">
                    <div class="flex items-center space-x-4">
                        <img src="http://127.0.0.1:8000/images/${item.image}" alt="${item.name}" class="h-16 object-cover rounded-lg">
                        <div>
                            <h4 class="text-sm font-medium text-white">${item.name}</h4>
                            <p class="text-sm text-gray-300">${item.quantity} x €${parseFloat(item.price).toFixed(2)}</p>
                        </div>
                    </div>
                    <span class="text-sm font-medium text-white">€${itemTotal.toFixed(2)}</span>
                </div>
            `;
        });

        // Calcular costes
        const subtotal = total; // Este es el subtotal de los productos
        const costeEnvio = subtotal >= 20 ? 0 : 3.50;
        const totalSinIva = subtotal + costeEnvio;
        const iva = totalSinIva * 0.21;
        const totalConIva = totalSinIva + iva;
        
        cartItems.innerHTML += `
            <div class="mt-4 space-y-2">
                <div class="flex justify-between text-sm text-gray-300">
                    <span>Subtotal:</span>
                    <span>€${subtotal.toFixed(2)}</span>
                </div>
                <div class="flex justify-between text-sm text-gray-300">
                    <span>Envío:</span>
                    <span>${costeEnvio === 0 ? 'Gratis' : `€${costeEnvio.toFixed(2)}`}</span>
                </div>
                <div class="flex justify-between text-sm text-gray-300">
                    <span>IVA (21%):</span>
                    <span>€${iva.toFixed(2)}</span>
                </div>
                <div class="flex justify-between text-lg font-bold text-white">
                    <span>Total:</span>
                    <span>€${totalConIva.toFixed(2)}</span>
                </div>
            </div>
        `;

        // Mostrar mensaje de envío gratis si aplica
        if (costeEnvio > 0) {
            const faltante = 20 - subtotal;
            cartItems.innerHTML += `
                <div class="mt-4 text-sm text-[#F3C71E]">
                    Te faltan €${faltante.toFixed(2)} para conseguir envío gratis
                </div>
            `;
        }

        // Actualizar el precio en el botón de pago
        document.getElementById('payment-amount').textContent = `€${totalConIva.toFixed(2)}`;
    } else {
        cartItems.innerHTML = '<p class="text-white">No hay productos en el carrito</p>';
    }

    // Funciones de validación
    function validarCodigoPostal(codigoPostal) {
        return /^\d{5}$/.test(codigoPostal);
    }

    function validarTelefono(telefono) {
        // Permite números con o sin prefijo +34
        const telefonoLimpio = telefono.replace(/^\+34/, '');
        return /^\d{9}$/.test(telefonoLimpio); 
    }

    function validarNumeroTarjeta(numero) {
        return /^\d{16}$/.test(numero.replace(/\s/g, ''));
    }

    function validarCVV(cvv) {
        // Los CVV siempre son 3 dígitos para tarjetas Visa/Mastercard
        // Solo American Express usa 4 dígitos
        return /^\d{3}$/.test(cvv);
    }

    function validarFechaExpiracion(fecha) {
        const [mes, anio] = fecha.split('/');
        if (!mes || !anio) {
            mostrarError('expiracion', 'Formato de fecha inválido (MM/YY)');
            return false;
        }
        
        const mesActual = new Date().getMonth() + 1;
        const anioActual = new Date().getFullYear() % 100;
        
        const mesNum = parseInt(mes);
        const anioNum = parseInt(anio);
        
        if (mesNum < 1 || mesNum > 12) {
            mostrarError('expiracion', 'El mes debe estar entre 01 y 12');
            return false;
        }
        
        // Validar si la fecha es anterior a la actual
        if (anioNum < anioActual || (anioNum === anioActual && mesNum < mesActual)) {
            mostrarError('expiracion', 'La tarjeta ha expirado');
            return false;
        }

        // Validar que no sea una fecha muy futura (máximo 10 años)
        const anioMaximo = (anioActual + 10) % 100;
        if (anioNum > anioMaximo) {
            mostrarError('expiracion', 'La fecha de expiración no puede ser más de 10 años en el futuro');
            return false;
        }
        
        return true;
    }

    // Función para mostrar errores
    function mostrarError(campo, mensaje) {
        const errorDiv = document.getElementById(`${campo}-error`);
        const inputElement = document.getElementById(campo);
        
        if (errorDiv) {
            errorDiv.textContent = mensaje;
            errorDiv.style.display = 'block';
        }
        
        if (inputElement) {
            inputElement.classList.add('input-error');
        }
    }

    function limpiarError(campo) {
        const errorDiv = document.getElementById(`${campo}-error`);
        const inputElement = document.getElementById(campo);
        
        if (errorDiv) {
            errorDiv.textContent = '';
            errorDiv.style.display = 'none';
        }
        
        if (inputElement) {
            inputElement.classList.remove('input-error');
        }
    }

    // Configurar validación de campos numéricos
    document.getElementById('codigo_postal').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^\d]/g, '');
        if (this.value.length > 5) this.value = this.value.slice(0, 5);
    });

    document.getElementById('telefono').addEventListener('input', function(e) {
        let value = this.value;
        
        // Si el usuario empieza con +34, lo mantenemos
        if (value.startsWith('+34')) {
            value = '+34' + value.substring(3).replace(/[^\d]/g, '');
        } else {
            value = value.replace(/[^\d]/g, '');
        }
        
        // Limitar la longitud total (incluyendo +34 si existe)
        if (value.startsWith('+34')) {
            if (value.length > 12) value = value.slice(0, 12);
        } else {
            if (value.length > 9) value = value.slice(0, 9);
        }
        
        this.value = value;
    });

    document.getElementById('numero').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^\d]/g, '');
        if (this.value.length > 16) this.value = this.value.slice(0, 16);
    });

    // Configurar formato automático de fecha de expiración
    document.getElementById('expiracion').addEventListener('input', function(e) {
        // Obtener solo los números del valor actual
        let value = this.value.replace(/[^\d]/g, '');
        
        // Si hay al menos 2 dígitos, formatear como MM/YY
        if (value.length >= 2) {
            const mes = parseInt(value.substring(0, 2));
            if (mes > 12) {
                value = '12' + value.substring(2);
            }
            
            value = value.substring(0, 2) + '/' + value.substring(2);
        }
        
        // Limitar la longitud total a 5 caracteres (MM/YY)
        if (value.length > 5) {
            value = value.substring(0, 5);
        }
        
        // Actualizar el valor del campo
        this.value = value;
    });

    // Configurar validación de CVV
    document.getElementById('cvv').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^\d]/g, '');
        if (this.value.length > 3) this.value = this.value.slice(0, 3);
    });

    // Manejar el envío del formulario
    document.getElementById('payment-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        let hayErrores = false;

        // Validar campos de envío
        const direccion = document.getElementById('direccion_envio').value;
        const codigoPostal = document.getElementById('codigo_postal').value;
        const ciudad = document.getElementById('ciudad').value;
        const telefono = document.getElementById('telefono').value;
        const nombre = document.getElementById('nombre').value;
        const numero = document.getElementById('numero').value;
        const expiracion = document.getElementById('expiracion').value;
        const cvv = document.getElementById('cvv').value;

        // Validar cada campo
        if (!direccion) {
            mostrarError('direccion_envio', 'La dirección es obligatoria');
            hayErrores = true;
        } else {
            limpiarError('direccion_envio');
        }

        if (!validarCodigoPostal(codigoPostal)) {
            mostrarError('codigo_postal', 'El código postal debe tener 5 dígitos');
            hayErrores = true;
        } else {
            limpiarError('codigo_postal');
        }

        if (!ciudad) {
            mostrarError('ciudad', 'La ciudad es obligatoria');
            hayErrores = true;
        } else {
            limpiarError('ciudad');
        }

        if (!validarTelefono(telefono)) {
            mostrarError('telefono', 'El teléfono debe tener 9 dígitos (puedes añadir el prefijo +34)');
            hayErrores = true;
        } else {
            limpiarError('telefono');
        }

        if (!nombre) {
            mostrarError('nombre', 'El nombre es obligatorio');
            hayErrores = true;
        } else {
            limpiarError('nombre');
        }

        if (!validarNumeroTarjeta(numero)) {
            mostrarError('numero', 'El número de tarjeta debe tener 16 dígitos');
            hayErrores = true;
        } else {
            limpiarError('numero');
        }

        if (!validarCVV(cvv)) {
            mostrarError('cvv', 'El CVV debe tener 3 dígitos');
            hayErrores = true;
        } else {
            limpiarError('cvv');
        }

        if (!validarFechaExpiracion(expiracion)) {
            hayErrores = true;
        } else {
            limpiarError('expiracion');
        }

        if (hayErrores) {
            return;
        }

        // Si no hay errores, continuar con el envío
        const formData = new FormData(this);
        
        // Obtener los items del carrito desde localStorage
        const items = carrito.map(item => ({
            id: item.id,
            quantity: parseInt(item.quantity),
            price: parseFloat(item.price)
        }));
        
        // Calcular el total final
        const costeEnvio = total >= 20 ? 0 : 3.50;
        const totalSinIva = total + costeEnvio;
        const iva = totalSinIva * 0.21;
        const totalConIva = totalSinIva + iva;

        // Crear el objeto de datos
        const data = {
            _token: '{{ csrf_token() }}',
            direccion_envio: direccion,
            codigo_postal: codigoPostal,
            ciudad: ciudad,
            telefono: telefono,
            nombre: nombre,
            numero: numero,
            expiracion: expiracion,
            cvv: cvv,
            items: JSON.stringify(items),
            total: totalConIva.toFixed(2)
        };

        // Enviar la petición
        fetch('{{ route("checkout.store") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Limpiar el carrito después de una compra exitosa
                localStorage.removeItem('cart');
                window.location.href = data.redirect;
            } else {
                alert(data.message || 'Ha ocurrido un error al procesar el pago');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Ha ocurrido un error al procesar el pago');
        });
    });
});
</script>
@endpush

@section('styles')
<style>
.error-message {
    color: #ff0000 !important;
    font-size: 0.875rem;
    margin-top: 0.25rem;
    display: none;
    font-weight: 500;
}

.input-error {
    border-color: #ff0000 !important;
}
</style>
@endsection 