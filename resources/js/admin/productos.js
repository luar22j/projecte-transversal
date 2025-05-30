// Funciones para manejar operaciones AJAX de productos
const ProductosManager = {
    // Actualizar stock de un producto
    async updateStock(productoId, newStock) {
        try {
            const response = await fetch(
                `/admin/productos/${productoId}/stock`,
                {
                    method: "PUT",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content,
                    },
                    body: JSON.stringify({ stock: newStock }),
                }
            );

            if (!response.ok) throw new Error("Error al actualizar el stock");

            const data = await response.json();
            this.showAlert("success", data.message);
            return data;
        } catch (error) {
            console.error("Error:", error);
            this.showAlert("error", "Error al actualizar el stock");
            throw error;
        }
    },

    // Actualizar precio de un producto
    async updatePrecio(productoId, newPrecio) {
        try {
            const response = await fetch(
                `/admin/productos/${productoId}/precio`,
                {
                    method: "PUT",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content,
                    },
                    body: JSON.stringify({ precio: newPrecio }),
                }
            );

            if (!response.ok) throw new Error("Error al actualizar el precio");

            const data = await response.json();
            this.showAlert("success", data.message);
            return data;
        } catch (error) {
            console.error("Error:", error);
            this.showAlert("error", "Error al actualizar el precio");
            throw error;
        }
    },

    // Eliminar un producto
    async deleteProducto(productoId) {
        if (!confirm("¿Estás seguro de que deseas eliminar este producto?"))
            return;

        try {
            const response = await fetch(`/admin/productos/${productoId}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                },
            });

            if (!response.ok) throw new Error("Error al eliminar el producto");

            const data = await response.json();
            this.showAlert("success", data.message);
            // Eliminar la fila de la tabla
            document.querySelector(`#producto-${productoId}`).remove();
            return data;
        } catch (error) {
            console.error("Error:", error);
            this.showAlert("error", "Error al eliminar el producto");
            throw error;
        }
    },

    // Mostrar alertas
    showAlert(type, message) {
        const alertContainer = document.getElementById("alert-container");
        const alert = document.createElement("div");
        alert.className = `alert alert-${type} mb-4 p-4 rounded`;
        alert.textContent = message;
        alertContainer.appendChild(alert);
        setTimeout(() => alert.remove(), 5000);
    },
};

// Inicializar eventos cuando el DOM esté listo
document.addEventListener("DOMContentLoaded", function () {
    // Eventos para actualizar stock
    document.querySelectorAll(".stock-input").forEach((input) => {
        input.addEventListener("change", async function () {
            const productoId = this.dataset.productoId;
            const newStock = this.value;
            try {
                await ProductosManager.updateStock(productoId, newStock);
            } catch (error) {
                this.value = this.dataset.originalValue;
            }
        });
    });

    // Eventos para actualizar precio
    document.querySelectorAll(".precio-input").forEach((input) => {
        input.addEventListener("change", async function () {
            const productoId = this.dataset.productoId;
            const newPrecio = this.value;
            try {
                await ProductosManager.updatePrecio(productoId, newPrecio);
            } catch (error) {
                this.value = this.dataset.originalValue;
            }
        });
    });

    // Eventos para eliminar productos
    document.querySelectorAll(".delete-producto").forEach((button) => {
        button.addEventListener("click", async function (e) {
            e.preventDefault();
            const productoId = this.dataset.productoId;
            try {
                await ProductosManager.deleteProducto(productoId);
            } catch (error) {
                console.error("Error al eliminar:", error);
            }
        });
    });
});
