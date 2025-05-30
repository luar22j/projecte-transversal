<div class="flex justify-start flex-col gap-6 bg-[#F3C71E] rounded-lg shadow-lg p-4 sm:p-6 lg:sticky lg:top-4 h-fit">
    <div class="flex flex-col gap-3">
        <div class="flex flex-col gap-2">
            <h2 class="text-xl font-bold text-[#1A323E]">
                Tu pedido a domicilio
            </h2>
            <p class="text-gray-600 text-sm">
                <i class="fas fa-map-marker-alt mr-2"></i>
                {{ Auth::user()->direccion ?? 'No hay dirección registrada' }}
            </p>
        </div>
    </div>

    <div class="flex flex-col gap-3" id="cart-sidebar">
        <!-- El contenido del carrito se cargará dinámicamente aquí -->
        <div class="text-center py-4 text-gray-600">
            Tu carrito está vacío
        </div>
    </div>

    <div class="flex flex-col gap-3">
        <h3 class="font-semibold text-[#1A323E]">Métodos de pago aceptados</h3>
        <div class="flex gap-4">
            <i class="fab fa-cc-visa text-3xl text-[#1A1F71]"></i>
            <i class="fab fa-cc-mastercard text-3xl text-[#EB001B]"></i>
            <i class="fab fa-cc-paypal text-3xl text-[#003087]"></i>
        </div>
    </div>

    <div class="flex flex-col gap-3 bg-[#F8F9FA] p-4 rounded-lg">
        <h3 class="font-semibold text-[#1A323E]">Información de envío</h3>
        <div class="text-sm text-gray-600">
            <p><i class="fas fa-truck mr-2 text-[#F3C71E]"></i>Envío en 30-45 minutos</p>
            <p><i class="fas fa-map-marker-alt mr-2 text-[#F3C71E]"></i>Radio de entrega: 5km</p>
            <p><i class="fas fa-euro-sign mr-2 text-[#F3C71E]"></i>Envío gratis en pedidos +20€</p>
        </div>
    </div>
</div>

<script defer>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('cart-sidebar');
    if (!sidebar) return;

    // Esperar a que el carrito esté disponible
    const waitForCart = setInterval(() => {
        if (window.cart) {
            clearInterval(waitForCart);
            window.cart.updateSidebar();
        }
    }, 100);

    // Actualizar el sidebar cuando cambie el carrito
    window.addEventListener('storage', function(e) {
        if (e.key === 'cart' && window.cart) {
            window.cart.updateSidebar();
        }
    });
});
</script>
