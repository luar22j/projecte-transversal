import InventarioService from "../services/InventarioService";
import ProductosTable from "../components/ProductosTable";

class InventarioPage {
    constructor() {
        this.table = new ProductosTable("productos-container", {
            onStockUpdate: this.handleStockUpdate.bind(this),
        });
        this.init();
    }

    async init() {
        this.bindEvents();
        await this.loadProductos();
    }

    bindEvents() {
        // Navegación
        document.querySelectorAll("[data-action]").forEach((button) => {
            button.addEventListener("click", (e) => {
                const action = e.target.dataset.action;
                this.handleAction(action);
            });
        });

        // Ordenamiento
        document.querySelectorAll("[data-sort]").forEach((button) => {
            button.addEventListener("click", (e) => {
                const { campo, orden } = e.target.dataset;
                this.handleSort(campo, orden);
            });
        });
    }

    async loadProductos() {
        try {
            const productos = await InventarioService.getProductos();
            this.table.updateProductos(productos);
        } catch (error) {
            this.table.showError(error.message);
        }
    }

    async handleAction(action) {
        try {
            let productos;
            switch (action) {
                case "todos":
                    productos = await InventarioService.getProductos();
                    break;
                case "agotados":
                    productos = await InventarioService.getProductosAgotados();
                    break;
                case "mas-vendidos":
                    productos =
                        await InventarioService.getProductosMasVendidos();
                    break;
            }
            this.table.updateProductos(productos);
        } catch (error) {
            this.table.showError(error.message);
        }
    }

    async handleSort(campo, orden) {
        try {
            const productos = await InventarioService.ordenarProductos(
                campo,
                orden
            );
            this.table.updateProductos(productos);
        } catch (error) {
            this.table.showError(error.message);
        }
    }

    async handleStockUpdate(productoId, stock) {
        await InventarioService.actualizarStock(productoId, stock);
        await this.loadProductos(); // Recargar la lista después de actualizar
    }
}

// Inicializar la página cuando el DOM esté listo
document.addEventListener("DOMContentLoaded", () => {
    new InventarioPage();
});
