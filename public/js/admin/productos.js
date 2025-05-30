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

// Funciones principales
const cargarProductos = async (page = 1) => {
    try {
        const response = await axios.get(`/admin/productos?page=${page}`);
        productos = response.data.data;
        totalPages = response.data.last_page;
        currentPage = response.data.current_page;
        renderizarTabla();
        renderizarPaginacion();
    } catch (error) {
        mostrarError("Error al cargar los productos");
    }
};

const eliminarProducto = async (id) => {
    if (!confirm("¿Estás seguro de que deseas eliminar este producto?")) {
        return;
    }

    try {
        await axios.delete(`/admin/productos/${id}`);
        await cargarProductos(currentPage);
        mostrarExito("Producto eliminado correctamente");
    } catch (error) {
        mostrarError("Error al eliminar el producto");
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
        <tr class="hover:bg-[#1A323E]">
            <td class="px-6 py-4 whitespace-nowrap">${producto.nombre}</td>
            <td class="px-6 py-4 whitespace-nowrap">
                ${
                    producto.descuento_activo
                        ? `
                    <div class="flex items-center space-x-2">
                        <span class="line-through text-gray-500">€${parseFloat(
                            producto.precio
                        ).toFixed(2)}</span>
                        <span class="text-green-600 font-bold">€${parseFloat(
                            producto.precio_con_descuento
                        ).toFixed(2)}</span>
                        <span class="bg-[#F3C71E] text-[#1A323E] px-2 py-1 rounded-full text-xs">
                            -${producto.descuento_activo.porcentaje}%
                        </span>
                    </div>
                `
                        : `€${parseFloat(producto.precio).toFixed(2)}`
                }
            </td>
            <td class="px-6 py-4 whitespace-nowrap">${producto.stock}</td>
            <td class="px-6 py-4 whitespace-nowrap">
                ${
                    producto.descuento_activo
                        ? `
                    <span class="text-sm text-gray-600">
                        ${producto.descuento_activo.nombre}
                        <br>
                        <small>Hasta ${new Date(
                            producto.descuento_activo.fecha_fin
                        ).toLocaleDateString()}</small>
                    </span>
                `
                        : `<span class="text-gray-400">Sin descuento</span>`
                }
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex justify-center space-x-2">
                    <a href="/admin/productos/${producto.id}/edit" 
                       class="text-blue-600 hover:text-blue-800">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button onclick="eliminarProducto(${producto.id})" 
                            class="text-red-600 hover:text-red-800">
                        <i class="fas fa-trash"></i>
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

    // Si solo hay una página, ocultamos la paginación
    if (totalPages <= 1) {
        paginacion.innerHTML = "";
        return;
    }

    let html = '<div class="flex justify-center space-x-2">';

    // Botón anterior
    html += `
        <button onclick="cambiarPagina(${currentPage - 1})"
                class="px-3 py-1 rounded-lg ${
                    currentPage === 1
                        ? "bg-gray-200 text-gray-500 cursor-not-allowed"
                        : "bg-[#F3C71E] text-[#1A323E] hover:bg-[#f4cf3c]"
                }"
                ${currentPage === 1 ? "disabled" : ""}>
            Anterior
        </button>
    `;

    // Números de página
    for (let i = 1; i <= totalPages; i++) {
        html += `
            <button onclick="cambiarPagina(${i})"
                    class="px-3 py-1 rounded-lg ${
                        i === currentPage
                            ? "bg-[#1A323E] text-white"
                            : "bg-[#F3C71E] text-[#1A323E] hover:bg-[#f4cf3c]"
                    }">
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
                        : "bg-[#F3C71E] text-[#1A323E] hover:bg-[#f4cf3c]"
                }"
                ${currentPage === totalPages ? "disabled" : ""}>
            Siguiente
        </button>
    `;

    html += "</div>";
    paginacion.innerHTML = html;
};

// Funciones de UI
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
    cargarProductos();
});

// Funciones globales para uso en HTML
window.cambiarPagina = (page) => {
    if (page >= 1 && page <= totalPages) {
        cargarProductos(page);
    }
};

window.eliminarProducto = eliminarProducto;
