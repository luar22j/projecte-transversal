document.addEventListener("DOMContentLoaded", function () {
    // Función para actualizar el carrito
    function actualizarCarrito() {
        fetch("/carrito/items")
            .then((response) => response.json())
            .then((data) => {
                const carritoTotal = document.getElementById("carrito-total");
                if (carritoTotal) {
                    carritoTotal.textContent = `€${data.total.toFixed(2)}`;
                }

                // Actualizar el contador de items
                const itemCount = document.querySelector(
                    ".text-sm.text-gray-500"
                );
                if (itemCount) {
                    itemCount.textContent = `${data.itemCount} items`;
                }

                // Actualizar la lista de items
                const carritoItems = document.querySelector(
                    ".flex.flex-col.gap-3"
                );
                if (carritoItems) {
                    if (data.items && data.items.length > 0) {
                        carritoItems.innerHTML = data.items
                            .map(
                                (item) => `
                            <div class="flex flex-col gap-2 bg-[#1A323E] p-3 sm:p-4 rounded-lg shadow">
                                <div class="flex items-center gap-3 sm:gap-4">
                                    <img src="/images/${
                                        item.producto.imagen
                                    }" alt="${
                                    item.producto.nombre
                                }" class="w-14 sm:w-16 object-cover rounded-lg">
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-semibold text-white truncate">${
                                            item.producto.nombre
                                        }</h3>
                                        <p class="text-sm text-gray-300">€${item.precio_unitario.toFixed(
                                            2
                                        )}</p>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center gap-2">
                                        <form action="/carrito/${
                                            item.id
                                        }" method="POST" class="flex items-center">
                                            <input type="hidden" name="_token" value="${
                                                document.querySelector(
                                                    'meta[name="csrf-token"]'
                                                ).content
                                            }">
                                            <input type="hidden" name="_method" value="PUT">
                                            <button type="submit" class="bg-[#F3C71E] hover:bg-[#f4cf3c] rounded-full w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center transition-colors" onclick="this.form.querySelector('input[name=cantidad]').value = Math.max(1, parseInt(this.form.querySelector('input[name=cantidad]').value) - 1)">
                                                <span class="text-[#1A323E] font-bold text-lg">-</span>
                                            </button>
                                            <input type="number" name="cantidad" value="${
                                                item.cantidad
                                            }" min="1" class="w-14 sm:w-16 text-center rounded-lg border-gray-300 bg-gray-700 text-white [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                            <button type="submit" class="bg-[#F3C71E] hover:bg-[#f4cf3c] rounded-full w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center transition-colors" onclick="this.form.querySelector('input[name=cantidad]').value = parseInt(this.form.querySelector('input[name=cantidad]').value) + 1">
                                                <span class="text-[#1A323E] font-bold text-lg">+</span>
                                            </button>
                                        </form>
                                    </div>
                                    <p class="font-semibold text-white">€${item.subtotal.toFixed(
                                        2
                                    )}</p>
                                </div>
                            </div>
                        `
                            )
                            .join("");
                    } else {
                        carritoItems.innerHTML = "";
                    }
                }
            })
            .catch((error) => console.error("Error:", error));
    }

    // Actualizar el carrito cuando se añade un producto
    document.addEventListener("productoAgregado", function () {
        actualizarCarrito();
    });

    // Actualizar el carrito cada 30 segundos
    setInterval(actualizarCarrito, 30000);

    // Actualizar el carrito al cargar la página
    actualizarCarrito();
});
