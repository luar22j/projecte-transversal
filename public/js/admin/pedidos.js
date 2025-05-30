// Configuración de Axios
axios.defaults.headers.common["X-CSRF-TOKEN"] = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");

// Estado global
let pedidos = [];
let currentPage = 1;
let totalPages = 1;

// Funciones principales
const cargarPedidos = async (page = 1) => {
    try {
        const response = await axios.get(`/admin/pedidos?page=${page}`);
        if (response.data && response.data.data) {
            pedidos = response.data.data;
            totalPages = response.data.last_page;
            currentPage = response.data.current_page;
            renderizarTabla();
            renderizarPaginacion();
        } else {
            mostrarError("Formato de respuesta inválido");
        }
    } catch (error) {
        console.error("Error al cargar pedidos:", error);
        mostrarError(
            error.response?.data?.message || "Error al cargar los pedidos"
        );
    }
};

const verDetallesPedido = async (id) => {
    try {
        const response = await axios.get(`/admin/pedidos/${id}`);
        const pedido = response.data;
        mostrarModalDetalles(pedido);
    } catch (error) {
        mostrarError("Error al cargar los detalles del pedido");
    }
};

const actualizarEstadoPedido = async (id, estado) => {
    try {
        const response = await axios.put(`/admin/pedidos/${id}/estado`, {
            estado,
        });
        await cargarPedidos(currentPage);
        mostrarExito("Estado del pedido actualizado correctamente");
    } catch (error) {
        console.error("Error al actualizar estado:", error);
        mostrarError(
            error.response?.data?.message ||
                "Error al actualizar el estado del pedido"
        );
    }
};

// Funciones de renderizado
const renderizarTabla = () => {
    const tbody = document.querySelector("#pedidosTable tbody");

    if (pedidos.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                    No hay pedidos disponibles
                </td>
            </tr>
        `;
        return;
    }

    tbody.innerHTML = pedidos
        .map(
            (pedido) => `
        <tr class="hover:bg-[#F3C71E] hover:bg-opacity-5 transition-colors">
            <td class="px-6 py-4 whitespace-nowrap text-[#1A323E] dark:text-white">${
                pedido.id
            }</td>
            <td class=" px-6 py-4 whitespace-nowrap text-[#1A323E] dark:text-white">${
                pedido.user.nombre
            }</td>
            <td class="text-center px-6 py-4 whitespace-nowrap text-[#1A323E] dark:text-white">${formatearFecha(
                pedido.created_at
            )}</td>
            <td class="text-center px-6 py-4 whitespace-nowrap text-[#1A323E] dark:text-white">${formatearPrecio(
                pedido.total
            )}</td>
            <td class="text-center px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${getEstadoClass(
                    pedido.estado.nombre
                )}">
                    ${
                        pedido.estado.nombre.charAt(0).toUpperCase() +
                        pedido.estado.nombre.slice(1)
                    }
                </span>
            </td>
            <td class="px-6 py-4 text-center">
                <div class="flex justify-center space-x-3">
                    <button onclick="verDetallesPedido(${pedido.id})"
                            class="text-[#1A323E] dark:text-white hover:text-[#F3C71E] transition-colors">
                        <i class="fas fa-eye mr-1"></i>Ver Detalles
                    </button>
                    <select onchange="actualizarEstadoPedido(${
                        pedido.id
                    }, this.value)"
                            class="text-sm rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                        <option value="pendiente" ${
                            pedido.estado.nombre === "pendiente"
                                ? "selected"
                                : ""
                        }>Pendiente</option>
                        <option value="en_proceso" ${
                            pedido.estado.nombre === "en_proceso"
                                ? "selected"
                                : ""
                        }>En Proceso</option>
                        <option value="enviado" ${
                            pedido.estado.nombre === "enviado" ? "selected" : ""
                        }>Enviado</option>
                        <option value="entregado" ${
                            pedido.estado.nombre === "entregado"
                                ? "selected"
                                : ""
                        }>Entregado</option>
                        <option value="cancelado" ${
                            pedido.estado.nombre === "cancelado"
                                ? "selected"
                                : ""
                        }>Cancelado</option>
                    </select>
                </div>
            </td>
        </tr>
    `
        )
        .join("");
};

const renderizarPaginacion = () => {
    const paginacion = document.querySelector("#paginacion");

    // Si solo hay una página, ocultamos la paginación
    if (totalPages <= 1) {
        paginacion.innerHTML = "";
        return;
    }

    let html = '<div class="flex justify-center space-x-2">';

    // Botón anterior
    html += `
        <button onclick="cambiarPagina(${currentPage - 1})" 
                class="px-3 py-1 rounded ${
                    currentPage === 1
                        ? "bg-gray-200 cursor-not-allowed"
                        : "bg-[#F3C71E] hover:bg-opacity-90"
                }"
                ${currentPage === 1 ? "disabled" : ""}>
            Anterior
        </button>
    `;

    // Números de página
    for (let i = 1; i <= totalPages; i++) {
        html += `
            <button onclick="cambiarPagina(${i})" 
                    class="px-3 py-1 rounded ${
                        currentPage === i
                            ? "bg-[#F3C71E]"
                            : "bg-gray-200 hover:bg-gray-300"
                    }">
                ${i}
            </button>
        `;
    }

    // Botón siguiente
    html += `
        <button onclick="cambiarPagina(${currentPage + 1})" 
                class="px-3 py-1 rounded ${
                    currentPage === totalPages
                        ? "bg-gray-200 cursor-not-allowed"
                        : "bg-[#F3C71E] hover:bg-opacity-90"
                }"
                ${currentPage === totalPages ? "disabled" : ""}>
            Siguiente
        </button>
    `;

    html += "</div>";
    paginacion.innerHTML = html;
};

// Funciones de utilidad
const formatearFecha = (fecha) => {
    return new Date(fecha).toLocaleDateString("es-ES", {
        year: "numeric",
        month: "long",
        day: "numeric",
        hour: "2-digit",
        minute: "2-digit",
    });
};

const formatearPrecio = (precio) => {
    return new Intl.NumberFormat("es-ES", {
        style: "currency",
        currency: "EUR",
    }).format(precio);
};

const getEstadoClass = (estado) => {
    const clases = {
        pendiente:
            "bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300",
        en_proceso:
            "bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300",
        enviado:
            "bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300",
        entregado:
            "bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300",
        cancelado: "bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300",
    };
    return (
        clases[estado] ||
        "bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300"
    );
};

// Funciones de UI
const mostrarModalDetalles = (pedido) => {
    const modal = document.getElementById("modalDetalles");
    const contenido = document.getElementById("modalDetallesContenido");

    contenido.innerHTML = `
        <div class="p-6">
            <h3 class="text-lg font-medium text-[#1A323E] dark:text-white mb-4">
                Detalles del Pedido #${pedido.id}
            </h3>
            
            <div class="mb-4">
                <h4 class="font-medium text-[#1A323E] dark:text-white mb-2">Información del Cliente</h4>
                <p class="text-gray-600 dark:text-gray-400">Nombre: ${
                    pedido.user.nombre
                }</p>
                <p class="text-gray-600 dark:text-gray-400">Email: ${
                    pedido.user.email
                }</p>
                <p class="text-gray-600 dark:text-gray-400">Teléfono: ${
                    pedido.user.telefono || "No especificado"
                }</p>
            </div>

            <div class="mb-4">
                <h4 class="font-medium text-[#1A323E] dark:text-white mb-2">Dirección de Envío</h4>
                <p class="text-gray-600 dark:text-gray-400">${
                    pedido.direccion_envio
                }</p>
            </div>

            <div class="mb-4">
                <h4 class="font-medium text-[#1A323E] dark:text-white mb-2">Productos</h4>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Producto</th>
                                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Cantidad</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Precio</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            ${pedido.detalles
                                .map(
                                    (detalle) => `
                                <tr>
                                    <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">${
                                        detalle.producto.nombre
                                    }</td>
                                    <td class="px-4 py-2 text-sm text-center text-gray-900 dark:text-white">${
                                        detalle.cantidad
                                    }</td>
                                    <td class="px-4 py-2 text-sm text-right text-gray-900 dark:text-white">${formatearPrecio(
                                        detalle.precio_unitario
                                    )}</td>
                                    <td class="px-4 py-2 text-sm text-right text-gray-900 dark:text-white">${formatearPrecio(
                                        detalle.precio_unitario *
                                            detalle.cantidad
                                    )}</td>
                                </tr>
                            `
                                )
                                .join("")}
                        </tbody>
                        <tfoot class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <td colspan="3" class="px-4 py-2 text-right font-medium text-gray-900 dark:text-white">Total:</td>
                                <td class="px-4 py-2 text-right font-medium text-gray-900 dark:text-white">${formatearPrecio(
                                    pedido.total
                                )}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    `;

    modal.classList.remove("hidden");
};

const cerrarModalDetalles = () => {
    const modal = document.getElementById("modalDetalles");
    modal.classList.add("hidden");
};

const mostrarError = (mensaje) => {
    const alertContainer = document.getElementById("alert-container");
    alertContainer.innerHTML = `
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">${mensaje}</span>
        </div>
    `;
    setTimeout(() => {
        alertContainer.innerHTML = "";
    }, 5000);
};

const mostrarExito = (mensaje) => {
    const alertContainer = document.getElementById("alert-container");
    alertContainer.innerHTML = `
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">${mensaje}</span>
        </div>
    `;
    setTimeout(() => {
        alertContainer.innerHTML = "";
    }, 5000);
};

// Event Listeners
document.addEventListener("DOMContentLoaded", () => {
    cargarPedidos();

    // Cerrar modal al hacer clic fuera
    const modal = document.getElementById("modalDetalles");
    modal.addEventListener("click", (e) => {
        if (e.target === modal) {
            cerrarModalDetalles();
        }
    });
});

// Funciones globales para uso en HTML
window.cambiarPagina = (page) => {
    if (page >= 1 && page <= totalPages) {
        cargarPedidos(page);
    }
};

window.verDetallesPedido = verDetallesPedido;
window.actualizarEstadoPedido = actualizarEstadoPedido;
window.cerrarModalDetalles = cerrarModalDetalles;
