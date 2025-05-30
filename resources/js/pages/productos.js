import ProductoService from "@/services/ProductoService";
import ProductosTable from "@/components/ProductosTable";

class ProductosPage {
    constructor() {
        this.table = new ProductosTable("productos-container", {
            onEdit: this.handleEdit.bind(this),
            onDelete: this.handleDelete.bind(this),
        });
        this.init();
    }

    async init() {
        this.bindEvents();
        await this.loadProductos();
    }

    bindEvents() {
        document
            .querySelector("[data-action='create']")
            ?.addEventListener("click", () => {
                window.location.href = "/admin/productos/create";
            });
    }

    async loadProductos() {
        try {
            const productos = await ProductoService.getProductos();
            this.table.updateProductos(productos);
        } catch (error) {
            this.table.showError(error.message);
        }
    }

    async handleEdit(productoId) {
        window.location.href = `/admin/productos/${productoId}/edit`;
    }

    async handleDelete(productoId) {
        try {
            await ProductoService.deleteProducto(productoId);
            this.table.showSuccess("Producto eliminado correctamente");
            await this.loadProductos();
        } catch (error) {
            this.table.showError(error.message);
        }
    }
}

// Inicializar la página cuando el DOM esté listo
document.addEventListener("DOMContentLoaded", () => {
    new ProductosPage();
});
