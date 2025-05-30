// Funciones para manejar operaciones AJAX de subcategorías
const SubcategoriasManager = {
    // Actualizar categoría de una subcategoría
    async updateCategoria(subcategoriaId, newCategoriaId) {
        try {
            const response = await fetch(
                `/admin/subcategorias/${subcategoriaId}/categoria`,
                {
                    method: "PUT",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content,
                    },
                    body: JSON.stringify({ categoria_id: newCategoriaId }),
                }
            );

            if (!response.ok)
                throw new Error("Error al actualizar la categoría");

            const data = await response.json();
            this.showAlert("success", data.message);
            return data;
        } catch (error) {
            console.error("Error:", error);
            this.showAlert("error", "Error al actualizar la categoría");
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
    // Eventos para cambiar categoría
    document.querySelectorAll(".categoria-select").forEach((select) => {
        select.addEventListener("change", async function () {
            const subcategoriaId = this.dataset.subcategoriaId;
            const newCategoriaId = this.value;
            const originalValue = this.dataset.originalValue;

            try {
                await SubcategoriasManager.updateCategoria(
                    subcategoriaId,
                    newCategoriaId
                );
                this.dataset.originalValue = newCategoriaId;
            } catch (error) {
                this.value = originalValue;
            }
        });
    });
});
