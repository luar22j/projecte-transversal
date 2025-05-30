// Configuración de Axios
axios.defaults.headers.common["X-CSRF-TOKEN"] = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");

// Estado global
let productos = [];
let currentPage = 1;
let totalPages = 1;

// Funciones de utilidad
const formatPrice = (price) => {
    return new Intl.NumberFormat("es-ES", {
        style: "currency",
        currency: "EUR",
    }).format(price);
};

const formatDate = (date) => {
    return new Date(date).toLocaleDateString("es-ES", {
        day: "2-digit",
        month: "2-digit",
        year: "numeric",
        hour: "2-digit",
        minute: "2-digit",
    });
};

// Funciones principales
const cargarProductos = async (page = 1) => {
    try {
        const response = await axios.get(`/admin/inventario?page=${page}`);
        productos = response.data.data;
        totalPages = response.data.last_page;
        currentPage = response.data.current_page;

        const tbody = document.querySelector("#productosTable tbody");
        if (!tbody) {
            console.error("No se encontró la tabla de productos");
            return;
        }

        renderizarTabla();
        renderizarPaginacion();
    } catch (error) {
        console.error("Error al cargar productos:", error);
        mostrarError(
            "Error al cargar los productos. Por favor, intenta recargar la página."
        );
    }
};

const actualizarStock = async (id, stock) => {
    try {
        await axios.put(`/admin/inventario/${id}/stock`, { stock });
        await cargarProductos(currentPage);
        mostrarExito("Stock actualizado correctamente");
    } catch (error) {
        console.error("Error al actualizar stock:", error);
        mostrarError(
            "Error al actualizar el stock. Por favor, intenta de nuevo."
        );
    }
};

const editarStock = (id, stockActual) => {
    document.getElementById("producto_id").value = id;
    document.getElementById("stock").value = stockActual;
    document.getElementById("editarStockModal").classList.remove("hidden");
};

const cerrarModalEditarStock = () => {
    document.getElementById("editarStockModal").classList.add("hidden");
};

const guardarStock = async () => {
    const id = document.getElementById("producto_id").value;
    const stock = document.getElementById("stock").value;

    if (stock < 0) {
        mostrarError("El stock no puede ser negativo");
        return;
    }

    await actualizarStock(id, stock);
    cerrarModalEditarStock();
};

const verDetalles = async (id) => {
    try {
        const response = await axios.get(`/admin/inventario/${id}`);

        if (response.data) {
            const producto = response.data;
            mostrarModalDetalles(producto);
        } else {
            throw new Error("No se recibieron datos del producto");
        }
    } catch (error) {
        console.error("Error al cargar detalles:", error);
        if (error.response) {
            console.error("Respuesta del servidor:", error.response.data);
            console.error("Estado:", error.response.status);
        }
        mostrarError(
            "Error al cargar los detalles del producto. Por favor, intenta de nuevo."
        );
    }
};

// Funciones de renderizado
const renderizarTabla = () => {
    const tbody = document.querySelector("#productosTable tbody");
    if (!tbody) {
        console.error("No se encontró el cuerpo de la tabla");
        return;
    }

    tbody.innerHTML = productos
        .map(
            (producto) => `
        <tr class="hover:bg-[#F3C71E] hover:bg-opacity-5 transition-colors">
            <td class="px-6 py-4 whitespace-nowrap text-white dark:text-white">${
                producto.id
            }</td>
            <td class="px-6 py-4 whitespace-nowrap text-white dark:text-white">${
                producto.nombre
            }</td>
            <td class="px-6 py-4 whitespace-nowrap text-white dark:text-white">
                ${
                    producto.subcategoria
                        ? `${producto.subcategoria.categoria.nombre} > ${producto.subcategoria.nombre}`
                        : '<span class="text-gray-400">Sin categoría</span>'
                }
            </td>
            <td class="px-6 py-4 text-center">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                    ${
                        producto.stock > 5
                            ? "bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400"
                            : producto.stock > 0
                            ? "bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400"
                            : "bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400"
                    }">
                    ${producto.stock}
                </span>
            </td>
            <td class="px-6 py-4 text-center text-white dark:text-white">
                ${formatPrice(producto.precio)}
            </td>
            <td class="px-6 py-4 text-center text-white dark:text-white">
                ${producto.total_vendido || 0}
            </td>
            <td class="px-6 py-4 text-center">
                <div class="flex justify-center space-x-2">
                    <button onclick="editarStock(${producto.id}, ${
                producto.stock
            })" 
                            class="p-2 rounded-full text-white transition-colors duration-200"
                            title="Editar Stock">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button onclick="verDetalles(${producto.id})"
                            class="p-2 rounded-full text-white transition-colors duration-200"
                            title="Ver Detalles">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </td>
        </tr>
    `
        )
        .join("");
};

const renderizarPaginacion = () => {
    const paginacion = document.getElementById("paginacion");
    if (!paginacion) {
        console.error("No se encontró el contenedor de paginación");
        return;
    }

    // Si solo hay una página, ocultar la paginación
    if (totalPages <= 1) {
        paginacion.style.display = "none";
        return;
    }

    paginacion.style.display = "block";
    let html = '<div class="flex justify-center space-x-2">';

    // Botón anterior
    html += `
        <button onclick="cambiarPagina(${currentPage - 1})" 
                class="px-3 py-1 rounded-lg ${
                    currentPage === 1
                        ? "bg-gray-200 text-gray-500 cursor-not-allowed"
                        : "bg-[#F3C71E] text-white hover:bg-[#f4cf3c]"
                } transition-colors"
                ${currentPage === 1 ? "disabled" : ""}>
            Anterior
        </button>
    `;

    // Números de página
    for (let i = 1; i <= totalPages; i++) {
        html += `
            <button onclick="cambiarPagina(${i})" 
                    class="px-3 py-1 rounded-lg ${
                        currentPage === i
                            ? "bg-[#F3C71E] text-white"
                            : "bg-gray-200 text-gray-700 hover:bg-gray-300"
                    } transition-colors">
                ${i}
            </button>
        `;
    }

    // Botón siguiente
    html += `
        <button onclick="cambiarPagina(${currentPage + 1})" 
                class="px-3 py-1 rounded-lg ${
                    currentPage === totalPages
                        ? "bg-gray-200 text-gray-500 cursor-not-allowed"
                        : "bg-[#F3C71E] text-white hover:bg-[#f4cf3c]"
                } transition-colors"
                ${currentPage === totalPages ? "disabled" : ""}>
            Siguiente
        </button>
    `;

    html += "</div>";
    paginacion.innerHTML = html;
};

// Funciones de UI
const mostrarModalDetalles = (producto) => {
    const modal = document.getElementById("modalDetalles");
    const contenido = document.getElementById("modalDetallesContenido");
    if (!modal || !contenido) {
        console.error("No se encontró el modal de detalles");
        return;
    }

    // Parsear los ingredientes si existen
    let ingredientes = [];
    try {
        if (producto.ingredientes) {
            ingredientes = JSON.parse(producto.ingredientes);
        }
    } catch (e) {
        console.error("Error al parsear ingredientes:", e);
    }

    contenido.innerHTML = `
        <div class="p-6">
            <div class="flex flex-col md:flex-row gap-6 mb-6">
                <div class="md:w-1/3">
                    <img src="${producto.imagen_url}" alt="${
        producto.nombre
    }" class="w-full rounded-lg object-cover">
                </div>
                <div class="md:w-2/3">
                    <h3 class="text-2xl font-bold text-white mb-4">${
                        producto.nombre
                    }</h3>
                    <p class="text-gray-200 mb-4">${
                        producto.descripcion || "Sin descripción"
                    }</p>
                    <p class="text-2xl font-bold text-white mb-4">${formatPrice(
                        producto.precio
                    )}</p>
                    
                    ${
                        ingredientes.length > 0
                            ? `
                        <div class="mb-4">
                            <h4 class="font-semibold text-white mb-2">Ingredientes:</h4>
                            <ul class="list-disc list-inside text-gray-200">
                                ${ingredientes
                                    .map((ing) => `<li>${ing}</li>`)
                                    .join("")}
                            </ul>
                        </div>
                    `
                            : ""
                    }
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="font-semibold text-white mb-4">Información del Producto</h4>
                    <table class="w-full">
                        <tr class="border-b border-gray-200">
                            <th class="py-2 text-left text-gray-200">ID</th>
                            <td class="py-2 text-white">${producto.id}</td>
                        </tr>
                        <tr class="border-b border-gray-200">
                            <th class="py-2 text-left text-gray-200">Categoría</th>
                            <td class="py-2 text-white">${
                                producto.subcategoria
                                    ? `${producto.subcategoria.categoria.nombre} > ${producto.subcategoria.nombre}`
                                    : "Sin categoría"
                            }</td>
                        </tr>
                        <tr class="border-b border-gray-200">
                            <th class="py-2 text-left text-gray-200">Stock</th>
                            <td class="py-2 text-white">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    ${
                                        producto.stock > 5
                                            ? "bg-green-100 text-green-800"
                                            : producto.stock > 0
                                            ? "bg-yellow-100 text-yellow-800"
                                            : "bg-red-100 text-red-800"
                                    }">
                                    ${producto.stock}
                                </span>
                            </td>
                        </tr>
                        <tr class="border-b border-gray-200">
                            <th class="py-2 text-left text-gray-200">Fecha de Creación</th>
                            <td class="py-2 text-white">${formatDate(
                                producto.created_at
                            )}</td>
                        </tr>
                        <tr class="border-b border-gray-200">
                            <th class="py-2 text-left text-gray-200">Última Actualización</th>
                            <td class="py-2 text-white">${formatDate(
                                producto.updated_at
                            )}</td>
                        </tr>
                    </table>
                </div>
                <div>
                    <h4 class="font-semibold text-white mb-4">Estadísticas de Ventas</h4>
                    <table class="w-full">
                        <tr class="border-b border-gray-200">
                            <th class="py-2 text-left text-gray-200">Total Vendido</th>
                            <td class="py-2 text-white">${
                                producto.total_vendido || 0
                            } unidades</td>
                        </tr>
                        <tr class="border-b border-gray-200">
                            <th class="py-2 text-left text-gray-200">Última Venta</th>
                            <td class="py-2 text-white">${
                                producto.ultima_venta
                                    ? formatDate(producto.ultima_venta)
                                    : "Nunca"
                            }</td>
                        </tr>
                        <tr class="border-b border-gray-200">
                            <th class="py-2 text-left text-gray-200">Ingresos Totales</th>
                            <td class="py-2 text-white">${formatPrice(
                                producto.precio * (producto.total_vendido || 0)
                            )}</td>
                        </tr>
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
    if (!alertContainer) {
        console.error("No se encontró el contenedor de alertas");
        return;
    }

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
    if (!alertContainer) {
        console.error("No se encontró el contenedor de alertas");
        return;
    }

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
    const tbody = document.querySelector("#productosTable tbody");
    if (!tbody) {
        console.error("No se encontró la tabla de productos");
        return;
    }
    cargarProductos();

    // Cerrar modal de detalles al hacer clic fuera
    const modalDetalles = document.getElementById("modalDetalles");
    modalDetalles.addEventListener("click", (e) => {
        if (e.target === modalDetalles) {
            cerrarModalDetalles();
        }
    });

    // Cerrar modal de editar stock al hacer clic fuera
    const modalEditarStock = document.getElementById("editarStockModal");
    modalEditarStock.addEventListener("click", (e) => {
        if (e.target === modalEditarStock) {
            cerrarModalEditarStock();
        }
    });

    // Manejar la tecla Enter en el input de stock
    const stockInput = document.getElementById("stock");
    if (stockInput) {
        stockInput.addEventListener("keypress", (e) => {
            if (e.key === "Enter") {
                e.preventDefault();
                guardarStock();
            }
        });
    }
});

// Funciones globales para uso en HTML
window.cambiarPagina = (page) => {
    if (page >= 1 && page <= totalPages) {
        cargarProductos(page);
    }
};

window.cerrarModalDetalles = cerrarModalDetalles;
window.cerrarModalEditarStock = cerrarModalEditarStock;

// Hacer las funciones disponibles globalmente
window.cargarProductos = cargarProductos;
window.cambiarPagina = cambiarPagina;
window.editarStock = editarStock;
window.guardarStock = guardarStock;
window.verDetalles = verDetalles;
window.cerrarModalDetalles = cerrarModalDetalles;
window.cerrarModalEditarStock = cerrarModalEditarStock;

// Cargar productos al iniciar
document.addEventListener("DOMContentLoaded", () => {
    cargarProductos();
});
