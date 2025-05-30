// Configuración de Axios
axios.defaults.headers.common["X-CSRF-TOKEN"] = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");

// Estado global
let categorias = [];
let currentPage = 1;
let totalPages = 1;

// Funciones principales
const cargarCategorias = async (page = 1) => {
    try {
        const response = await axios.get(`/admin/categorias?page=${page}`);
        categorias = response.data.data;
        totalPages = response.data.last_page;
        currentPage = response.data.current_page;
        renderizarTabla();
        renderizarPaginacion();
    } catch (error) {
        mostrarError("Error al cargar las categorías");
    }
};

const eliminarCategoria = async (id) => {
    if (
        !confirm(
            "¿Estás seguro de que deseas eliminar esta categoría? Esta acción no se puede deshacer."
        )
    ) {
        return;
    }

    try {
        await axios.delete(`/admin/categorias/${id}`);
        await cargarCategorias(currentPage);
        mostrarExito("Categoría eliminada correctamente");
    } catch (error) {
        mostrarError("Error al eliminar la categoría");
    }
};

// Funciones de renderizado
const renderizarTabla = () => {
    const tbody = document.querySelector("#categoriasTable tbody");
    tbody.innerHTML = categorias
        .map(
            (categoria) => `
        <tr class="hover:bg-[#F3C71E] hover:bg-opacity-5 transition-colors">
            <td class="px-6 py-4 whitespace-nowrap text-[#1A323E] dark:text-white">${
                categoria.id
            }</td>
            <td class="px-6 py-4 whitespace-nowrap text-[#1A323E] dark:text-white">${
                categoria.nombre
            }</td>
            <td class="px-6 py-4 text-center text-[#1A323E] dark:text-white">
                ${categoria.subcategorias_count || 0}
            </td>
            <td class="px-6 py-4 text-center">
                <div class="flex justify-center space-x-3">
                    <a href="/admin/categorias/${categoria.id}/edit" 
                       class="text-[#1A323E] dark:text-white hover:text-[#F3C71E] transition-colors">
                        <i class="fas fa-edit mr-1"></i>Editar
                    </a>
                    <button onclick="eliminarCategoria(${categoria.id})"
                            class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 transition-colors">
                        <i class="fas fa-trash-alt mr-1"></i>Eliminar
                    </button>
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

// Funciones de UI
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
    cargarCategorias();
});

// Funciones globales para uso en HTML
window.cambiarPagina = (page) => {
    if (page >= 1 && page <= totalPages) {
        cargarCategorias(page);
    }
};

window.eliminarCategoria = eliminarCategoria;
