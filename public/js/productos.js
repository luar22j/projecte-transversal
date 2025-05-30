document.addEventListener("DOMContentLoaded", function () {
    // Configuración de Axios
    axios.defaults.headers.common["X-CSRF-TOKEN"] = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");
    axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

    // Elementos del DOM
    const alertContainer = document.getElementById("alert-container");
    const productosTable = document.querySelector("table tbody");

    // Función para mostrar alertas
    function showAlert(message, type = "success") {
        const alert = document.createElement("div");
        alert.className = `p-4 mb-4 rounded-lg ${
            type === "success"
                ? "bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400"
                : "bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400"
        }`;
        alert.textContent = message;
        alertContainer.appendChild(alert);
        setTimeout(() => alert.remove(), 3000);
    }

    // Función para actualizar el precio
    async function updatePrecio(productoId, precio) {
        try {
            const response = await axios.put(
                `/admin/productos/${productoId}/precio`,
                { precio }
            );
            showAlert("Precio actualizado correctamente");
        } catch (error) {
            showAlert("Error al actualizar el precio", "error");
            console.error("Error:", error);
        }
    }

    // Función para actualizar el stock
    async function updateStock(productoId, stock) {
        try {
            const response = await axios.put(
                `/admin/productos/${productoId}/stock`,
                { stock }
            );
            showAlert("Stock actualizado correctamente");
        } catch (error) {
            showAlert("Error al actualizar el stock", "error");
            console.error("Error:", error);
        }
    }

    // Función para actualizar la subcategoría
    async function updateSubcategoria(productoId, subcategoriaId) {
        try {
            const response = await axios.put(
                `/admin/productos/${productoId}/subcategoria`,
                { subcategoria_id: subcategoriaId }
            );
            showAlert("Subcategoría actualizada correctamente");
        } catch (error) {
            showAlert("Error al actualizar la subcategoría", "error");
            console.error("Error:", error);
        }
    }

    // Función para eliminar un producto
    async function deleteProducto(productoId) {
        if (!confirm("¿Estás seguro de que deseas eliminar este producto?")) {
            return;
        }

        try {
            const response = await axios.delete(
                `/admin/productos/${productoId}`
            );
            const row = document.querySelector(
                `tr[data-producto-id="${productoId}"]`
            );
            if (row) {
                row.remove();
                showAlert("Producto eliminado correctamente");
            }
        } catch (error) {
            showAlert("Error al eliminar el producto", "error");
            console.error("Error:", error);
        }
    }

    // Debounce para inputs
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Aplicar debounce a las actualizaciones
    const debouncedUpdatePrecio = debounce((productoId, precio) => {
        updatePrecio(productoId, precio);
    }, 500);

    const debouncedUpdateStock = debounce((productoId, stock) => {
        updateStock(productoId, stock);
    }, 500);

    // Event listeners con debounce
    productosTable.addEventListener("input", function (e) {
        const target = e.target;
        const productoId = target.dataset.productoId;

        if (target.classList.contains("precio-input")) {
            const precio = parseFloat(target.value);
            if (!isNaN(precio)) {
                debouncedUpdatePrecio(productoId, precio);
            }
        } else if (target.classList.contains("stock-input")) {
            const stock = parseInt(target.value);
            if (!isNaN(stock)) {
                debouncedUpdateStock(productoId, stock);
            }
        }
    });

    productosTable.addEventListener("change", function (e) {
        const target = e.target;
        if (target.classList.contains("subcategoria-select")) {
            const productoId = target.dataset.productoId;
            const subcategoriaId = target.value;
            updateSubcategoria(productoId, subcategoriaId);
        }
    });

    productosTable.addEventListener("click", function (e) {
        const target = e.target.closest(".delete-producto");
        if (target) {
            const productoId = target.dataset.productoId;
            deleteProducto(productoId);
        }
    });
});
