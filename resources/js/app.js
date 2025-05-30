import "./bootstrap";
import Alpine from "alpinejs";
import Cart from "./components/Cart";
import Marketplace from "./components/Marketplace";

window.Alpine = Alpine;
Alpine.start();

// Registrar el componente Cart globalmente
window.Cart = Cart;

// Inicializar el carrito globalmente
document.addEventListener("DOMContentLoaded", () => {
    // Inicializar el carrito globalmente
    window.cart = new Cart("#cart-container");

    // Inicializar el marketplace si estamos en la página correspondiente
    const marketplaceContainer = document.querySelector(".products-container");
    if (marketplaceContainer) {
        new Marketplace();
    }
});
