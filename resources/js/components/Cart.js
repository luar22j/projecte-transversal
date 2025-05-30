export default class Cart {
    constructor(containerSelector) {
        this.container = document.querySelector(containerSelector);
        this.items = [];
        this.loadFromSession();
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.render();
        this.updateHeaderCounter();
        this.updateSidebar();
    }

    loadFromSession() {
        // Intentar cargar desde localStorage primero
        const cartData = localStorage.getItem("cart");
        if (cartData) {
            this.items = JSON.parse(cartData);
        }
    }

    saveToSession() {
        localStorage.setItem("cart", JSON.stringify(this.items));
    }

    updateHeaderCounter() {
        const counter = document.querySelector(".cart-counter");
        if (counter) {
            const totalItems = this.items.reduce(
                (sum, item) => sum + item.quantity,
                0
            );
            counter.textContent = totalItems;
            counter.style.display = totalItems > 0 ? "flex" : "none";
        }
    }

    updateSidebar() {
        const sidebar = document.getElementById("cart-sidebar");
        if (!sidebar) return;

        const items = this.items;

        if (items.length === 0) {
            sidebar.innerHTML = `
                <div class="text-center py-4 text-gray-600">
                    Tu carrito está vacío
                </div>
            `;
            return;
        }

        const total = items.reduce(
            (sum, item) => sum + item.price * item.quantity,
            0
        );
        const itemsHtml = items
            .map((item) => {
                const subtotal = item.price * item.quantity;
                const imageUrl = item.image || "/images/default-product.jpg";

                return `
                <div class="flex flex-col gap-2 bg-[#1A323E] p-4 rounded-lg shadow">
                    <div class="flex items-center gap-4">
                        <img src="http://127.0.0.1:8000/images/${imageUrl}" alt="${
                    item.name
                }" class="w-16 object-cover rounded-lg">
                        <div class="flex-1 min-w-0">
                            <h3 class="font-semibold text-white truncate mb-1">${
                                item.name
                            }</h3>
                            ${
                                item.discount > 0
                                    ? `
                                <div class="flex flex-wrap gap-2 mb-2">
                                    <span class="line-through text-gray-400 text-sm">€${item.originalPrice.toFixed(
                                        2
                                    )}</span>
                                    <span class="text-green-400 text-sm font-semibold">€${item.price.toFixed(
                                        2
                                    )}</span>
                                    <span class="bg-[#F3C71E] text-[#1A323E] px-2 py-1 rounded-full text-xs font-bold">
                                        -${item.discount}%
                                    </span>
                                </div>
                            `
                                    : `
                                <p class="text-sm text-gray-300 mb-2">€${item.price.toFixed(
                                    2
                                )}</p>
                            `
                            }
                        </div>
                        <button type="button" onclick="window.cart.removeItem(${
                            item.id
                        })" class="text-gray-400 hover:text-red-500 transition-colors">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            <button type="button" class="bg-[#F3C71E] hover:bg-[#f4cf3c] rounded-full w-7 h-7 flex items-center justify-center transition-colors" onclick="window.cart.updateQuantity(${
                                item.id
                            }, ${item.quantity - 1})">
                                <span class="text-[#1A323E] font-bold text-lg">-</span>
                            </button>
                            <input type="number" value="${
                                item.quantity
                            }" min="1" class="w-12 text-center rounded-lg bg-gray-700 text-white [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none" onchange="window.cart.updateQuantity(${
                    item.id
                }, this.value)">
                            <button type="button" class="bg-[#F3C71E] hover:bg-[#f4cf3c] rounded-full w-7 h-7 flex items-center justify-center transition-colors" onclick="window.cart.updateQuantity(${
                                item.id
                            }, ${item.quantity + 1})">
                                <span class="text-[#1A323E] font-bold text-lg">+</span>
                            </button>
                        </div>
                        <p class="font-bold text-white">€${subtotal.toFixed(
                            2
                        )}</p>
                    </div>
                </div>
            `;
            })
            .join("");

        sidebar.innerHTML = `
            ${itemsHtml}
            <div class="mt-4 pt-4 border-t border-[#1A323E]">
                <div class="flex justify-between items-center mb-4">
                    <span class="font-semibold text-[#1A323E]">Total:</span>
                    <span class="font-bold text-lg text-[#1A323E]">€${total.toFixed(
                        2
                    )}</span>
                </div>
                <div class="text-sm text-gray-600 mb-4">
                    ${
                        total >= 20
                            ? '<p class="text-green-600"><i class="fas fa-check-circle mr-2"></i>¡Envío gratis!</p>'
                            : `<p>Faltan €${(20 - total).toFixed(
                                  2
                              )} para envío gratis</p>`
                    }
                </div>
                <div class="flex flex-col gap-2">
                    <a href="/carrito" class="bg-[#1A323E] text-white text-center py-2 px-4 rounded-lg hover:bg-[#2a4252] transition-colors">
                        Ver carrito completo
                    </a>
                    <a href="/checkout" class="bg-[#F3C71E] text-[#1A323E] text-center py-2 px-4 rounded-lg hover:bg-[#f4cf3c] transition-colors" onclick="event.preventDefault(); window.cart.proceedToCheckout();">
                        Proceder al pago
                    </a>
                </div>
            </div>
        `;
    }

    addItem(product) {
        const existingItem = this.items.find((item) => item.id === product.id);

        if (existingItem) {
            existingItem.quantity += product.cantidad || 1;
        } else {
            this.items.push({
                id: product.id,
                name: product.nombre,
                price: parseFloat(product.precio),
                image: product.imagen,
                quantity: product.cantidad || 1,
                discount: product.descuento || 0,
                originalPrice: product.descuento
                    ? parseFloat(product.precio) / (1 - product.descuento / 100)
                    : parseFloat(product.precio),
            });
        }

        this.saveToSession();
        this.render();
        this.updateSidebar();
        this.showNotification("Producto añadido al carrito");
    }

    updateQuantity(productId, newQuantity) {
        const quantity = parseInt(newQuantity);
        if (quantity < 1) return;

        const item = this.items.find((item) => item.id === productId);
        if (item) {
            item.quantity = quantity;
            this.saveToSession();
            this.render();
            this.updateHeaderCounter();
            this.updateSidebar();
        }
    }

    removeItem(productId) {
        if (
            !confirm(
                "¿Estás seguro de que quieres eliminar este producto del carrito?"
            )
        )
            return;

        this.items = this.items.filter((item) => item.id !== productId);
        this.saveToSession();
        this.render();
        this.updateHeaderCounter();
        this.updateSidebar();
        this.showNotification("Producto eliminado del carrito");
    }

    clearCart() {
        if (!confirm("¿Estás seguro de que quieres vaciar el carrito?")) return;

        this.items = [];
        this.saveToSession();
        this.render();
        this.updateHeaderCounter();
        this.updateSidebar();
        this.showNotification("Carrito vaciado");
    }

    getTotal() {
        return this.items.reduce(
            (total, item) => total + item.price * item.quantity,
            0
        );
    }

    showNotification(message, type = "success") {
        const notification = document.createElement("div");
        notification.className = `notification ${type}`;
        notification.textContent = message;
        document.body.appendChild(notification);
        setTimeout(() => notification.remove(), 3000);
    }

    render() {
        if (!this.container) return;

        if (this.items.length === 0) {
            this.container.innerHTML = `
                <div class="empty-cart flex flex-col items-center justify-center">
                    <p class="text-[#1A323E] text-center mb-4">Tu carrito está vacío</p>
                    <a href="/marketplace" class="bg-[#F3C71E] hover:bg-[#f4cf3c] text-[#1A323E] rounded-full px-6 py-2 font-semibold transition-colors inline-block">Ir a la tienda</a>
                </div>
            `;
            return;
        }

        const itemsHtml = this.items
            .map(
                (item) => `
            <div class="cart-item">
                <div class="flex items-center gap-4 bg-[#2b4958] rounded-lg p-4">
                    <img src="http://127.0.0.1:8000/images/${
                        item.image
                    }" alt="${item.name}" class="w-24 object-cover rounded-lg">
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-white mb-2">${
                            item.name
                        }</h3>
                        ${
                            item.discount > 0
                                ? `
                            <div class="flex items-center gap-2 mb-2">
                                <span class="line-through text-gray-400">€${item.originalPrice.toFixed(
                                    2
                                )}</span>
                                <span class="text-green-400 font-semibold">€${item.price.toFixed(
                                    2
                                )}</span>
                                <span class="bg-[#F3C71E] text-[#1A323E] px-2 py-1 rounded-full text-xs font-bold">
                                    -${item.discount}%
                                </span>
                            </div>
                        `
                                : `
                            <p class="text-white font-semibold mb-2">€${item.price.toFixed(
                                2
                            )}</p>
                        `
                        }
                        <div class="flex items-center gap-2">
                            <button type="button" onclick="cart.updateQuantity(${
                                item.id
                            }, ${
                    item.quantity - 1
                })" class="bg-[#F3C71E] hover:bg-[#f4cf3c] text-[#1A323E] rounded-full w-8 h-8 flex items-center justify-center transition-colors">
                                <span class="text-[#1A323E] font-bold">-</span>
                            </button>
                            <input type="number" value="${
                                item.quantity
                            }" min="1" class="w-16 text-center rounded-lg bg-gray-700 text-white [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none" onchange="cart.updateQuantity(${
                    item.id
                }, this.value)">
                            <button type="button" onclick="cart.updateQuantity(${
                                item.id
                            }, ${
                    item.quantity + 1
                })" class="bg-[#F3C71E] hover:bg-[#f4cf3c] text-[#1A323E] rounded-full w-8 h-8 flex items-center justify-center transition-colors">
                                <span class="text-[#1A323E] font-bold">+</span>
                            </button>
                        </div>
                    </div>
                    <div class="flex flex-col items-end gap-2">
                        <p class="text-lg font-bold text-white">€${(
                            item.price * item.quantity
                        ).toFixed(2)}</p>
                        <button type="button" onclick="cart.removeItem(${
                            item.id
                        })" class="text-gray-400 hover:text-red-500 transition-colors">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `
            )
            .join("");

        this.container.innerHTML = `
            <div class="space-y-4">
                ${itemsHtml}
                <div class="cart-summary bg-[#2b4958] rounded-lg p-4">
                    <div class="flex justify-between items-center">
                        <button type="button" onclick="cart.clearCart()" class="text-[#1A323E] bg-[#F3C71E] hover:bg-[#f4cf3c] rounded-full px-6 py-2 font-semibold transition-colors">
                            Vaciar Carrito
                        </button>
                        <div class="text-right">
                            <p class="text-xl font-bold text-white">Total: ${this.getTotal().toFixed(
                                2
                            )}€</p>
                            <a href="/checkout" class="checkout-button mt-2 inline-block text-[#1A323E] bg-[#F3C71E] hover:bg-[#f4cf3c] rounded-full px-6 py-2 font-semibold transition-colors" onclick="event.preventDefault(); cart.proceedToCheckout();">
                                Proceder al Pago
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    setupEventListeners() {
        window.cart = this;
    }

    async proceedToCheckout() {
        window.location.href = "/checkout";
    }
}
