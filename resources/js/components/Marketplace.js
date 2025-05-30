import { marketplaceService } from "../services/api";

export default class Marketplace {
    constructor() {
        this.products = [];
        this.categories = [];
        this.cart = window.cart || new Cart("#cart-container");
        this.init();
    }

    async init() {
        try {
            await this.loadCategories();
            await this.loadProducts();
            this.setupEventListeners();
            this.render();
        } catch (error) {
            console.error("Error initializing marketplace:", error);
            this.showError("Error al cargar los productos");
        }
    }

    async loadCategories() {
        try {
            const response = await marketplaceService.getCategories();
            this.categories = response.data;
        } catch (error) {
            console.error("Error loading categories:", error);
        }
    }

    async loadProducts() {
        try {
            const response = await marketplaceService.getProducts();
            this.products = response.data;
        } catch (error) {
            console.error("Error loading products:", error);
        }
    }

    setupEventListeners() {
        const container = document.querySelector(".products-container");
        if (!container) return;

        container.addEventListener("click", (e) => {
            if (e.target.matches(".add-to-cart")) {
                const productId = parseInt(e.target.dataset.productId);
                const product = this.products.find((p) => p.id === productId);
                if (product) {
                    this.cart.addItem(product);
                }
            }
        });
    }

    showError(message) {
        const container = document.querySelector(".products-container");
        if (container) {
            container.innerHTML = `
                <div class="alert alert-danger">
                    ${message}
                </div>
            `;
        }
    }

    render() {
        const container = document.querySelector(".products-container");
        if (!container) return;

        const productsHtml = this.products
            .map(
                (product) => `
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="${product.imagen || "/images/no-image.png"}" 
                         class="card-img-top" 
                         alt="${product.nombre}">
                    <div class="card-body">
                        <h5 class="card-title">${product.nombre}</h5>
                        <p class="card-text">${product.descripcion}</p>
                        <p class="card-text">
                            <strong>Precio:</strong> ${product.precio}€
                        </p>
                        <button class="btn btn-primary add-to-cart" 
                                data-product-id="${product.id}">
                            Añadir al Carrito
                        </button>
                    </div>
                </div>
            </div>
        `
            )
            .join("");

        container.innerHTML = `
            <div class="row">
                ${productsHtml}
            </div>
        `;
    }
}
