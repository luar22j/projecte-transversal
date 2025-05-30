document.addEventListener("DOMContentLoaded", async () => {
    const tbody = document.querySelector("tbody");
    const alertContainer = document.getElementById("alert-container");

    try {
        const response = await fetch("/admin/descuentos", {
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
                Accept: "application/json",
                "X-Requested-With": "XMLHttpRequest",
            },
            credentials: "same-origin",
        });

        if (!response.ok) {
            throw new Error("Error al cargar los descuentos");
        }

        const descuentos = await response.json();

        if (!Array.isArray(descuentos)) {
            throw new Error("Formato de datos inválido");
        }

        tbody.innerHTML = descuentos
            .map(
                (descuento) => `
            <tr class="hover:bg-gray-700">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-[#1A323E] dark:text-white">
                    ${descuento.nombre}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-[#1A323E] dark:text-white">
                    ${descuento.porcentaje}%
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-[#1A323E] dark:text-white">
                    ${new Date(descuento.fecha_inicio).toLocaleDateString()}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-[#1A323E] dark:text-white">
                    ${new Date(descuento.fecha_fin).toLocaleDateString()}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-center">
                    <button onclick="toggleActivo(${descuento.id}, ${
                    descuento.activo
                })" 
                            class="px-3 py-1 rounded-full text-sm font-medium ${
                                descuento.activo
                                    ? "bg-green-100 text-green-800"
                                    : "bg-red-100 text-red-800"
                            }">
                        ${descuento.activo ? "Activo" : "Inactivo"}
                    </button>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-[#1A323E] dark:text-white">
                    ${
                        descuento.productos ? descuento.productos.length : 0
                    } productos
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                    <div class="flex justify-center space-x-2">
                        <a href="/admin/descuentos/${descuento.id}/edit" 
                           class="text-[#F3C71E] hover:text-[#f4cf3c]">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button onclick="eliminarDescuento(${descuento.id})" 
                                class="text-red-600 hover:text-red-800">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `
            )
            .join("");
    } catch (error) {
        console.error("Error:", error);
        showAlert(error.message, "error");
        tbody.innerHTML =
            '<tr><td colspan="7" class="px-6 py-4 text-center text-red-600">Error al cargar los descuentos</td></tr>';
    }
});

async function toggleActivo(id, estadoActual) {
    try {
        const response = await fetch(`/admin/descuentos/${id}/toggle-activo`, {
            method: "PATCH",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
                Accept: "application/json",
                "X-Requested-With": "XMLHttpRequest",
            },
        });

        if (!response.ok) {
            throw new Error("Error al actualizar el estado");
        }

        const result = await response.json();
        showAlert("Estado actualizado correctamente", "success");

        // Recargar la página para mostrar los cambios
        setTimeout(() => window.location.reload(), 1000);
    } catch (error) {
        console.error("Error:", error);
        showAlert(error.message, "error");
    }
}

async function eliminarDescuento(id) {
    if (!confirm("¿Estás seguro de que deseas eliminar este descuento?")) {
        return;
    }

    try {
        const response = await fetch(`/admin/descuentos/${id}`, {
            method: "DELETE",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
                Accept: "application/json",
                "X-Requested-With": "XMLHttpRequest",
            },
        });

        if (!response.ok) {
            throw new Error("Error al eliminar el descuento");
        }

        const result = await response.json();
        showAlert("Descuento eliminado correctamente", "success");

        // Recargar la página para mostrar los cambios
        setTimeout(() => window.location.reload(), 1000);
    } catch (error) {
        console.error("Error:", error);
        showAlert(error.message, "error");
    }
}

function showAlert(message, type) {
    const container = document.getElementById("alert-container");
    const alert = document.createElement("div");
    alert.className = `p-4 mb-4 rounded-lg ${
        type === "success"
            ? "bg-green-100 text-green-700"
            : "bg-red-100 text-red-700"
    }`;
    alert.textContent = message;
    container.appendChild(alert);
    setTimeout(() => alert.remove(), 3000);
}
