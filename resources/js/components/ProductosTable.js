class ProductosTable {
    constructor(containerId, options = {}) {
        this.container = document.getElementById(containerId);
        this.options = {
            onEdit: () => {},
            onDelete: () => {},
            ...options,
        };
        this.init();
    }

    init() {
        this.render();
        this.bindEvents();
    }

    render() {
        this.container.innerHTML = `
            <table class="min-w-full">
                <thead>
                    <tr class="bg-[#F3C71E] bg-opacity-10">
                        <th class="px-6 py-4 border-b border-[#F3C71E] text-left text-xs font-semibold text-[#1A323E] dark:text-white uppercase tracking-wider">ID</th>
                        <th class="px-6 py-4 border-b border-[#F3C71E] text-left text-xs font-semibold text-[#1A323E] dark:text-white uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-4 border-b border-[#F3C71E] text-left text-xs font-semibold text-[#1A323E] dark:text-white uppercase tracking-wider">Categoría</th>
                        <th class="px-6 py-4 border-b border-[#F3C71E] text-center text-xs font-semibold text-[#1A323E] dark:text-white uppercase tracking-wider">Precio</th>
                        <th class="px-6 py-4 border-b border-[#F3C71E] text-center text-xs font-semibold text-[#1A323E] dark:text-white uppercase tracking-wider">Stock</th>
                        <th class="px-6 py-4 border-b border-[#F3C71E] text-center text-xs font-semibold text-[#1A323E] dark:text-white uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-4 border-b border-[#F3C71E] text-center text-xs font-semibold text-[#1A323E] dark:text-white uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody id="productos-table-body" class="divide-y divide-gray-200 dark:divide-gray-700">
                </tbody>
            </table>
        `;
    }

    bindEvents() {
        const tbody = document.getElementById("productos-table-body");
        tbody.addEventListener("click", (e) => {
            const editButton = e.target.closest("[data-action='edit']");
            const deleteButton = e.target.closest("[data-action='delete']");

            if (editButton) {
                const productoId = editButton.dataset.productoId;
                this.options.onEdit(productoId);
            }

            if (deleteButton) {
                const productoId = deleteButton.dataset.productoId;
                if (
                    confirm(
                        "¿Estás seguro de que deseas eliminar este producto?"
                    )
                ) {
                    this.options.onDelete(productoId);
                }
            }
        });
    }

    updateProductos(productos) {
        const tbody = document.getElementById("productos-table-body");
        tbody.innerHTML = productos
            .map((producto) => this.renderProductoRow(producto))
            .join("");
    }

    renderProductoRow(producto) {
        const stockClass = this.getStockClass(producto.stock);
        const estadoClass = this.getEstadoClass(producto.stock);
        const estado = producto.stock > 0 ? "Disponible" : "Sin Stock";

        return `
            <tr class="hover:bg-[#F3C71E] hover:bg-opacity-5 transition-colors">
                <td class="px-6 py-4 whitespace-nowrap text-[#1A323E] dark:text-white">
                    ${producto.id}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-[#1A323E] dark:text-white">
                    ${producto.nombre}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-[#1A323E] dark:text-white">
                    ${producto.subcategoria?.categoria?.nombre || "N/A"} / ${
            producto.subcategoria?.nombre || "N/A"
        }
                </td>
                <td class="px-6 py-4 text-center text-[#1A323E] dark:text-white">
                    ${this.formatPrice(producto.precio)}
                </td>
                <td class="px-6 py-4 text-center">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${stockClass}">
                        ${producto.stock}
                    </span>
                </td>
                <td class="px-6 py-4 text-center">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${estadoClass}">
                        ${estado}
                    </span>
                </td>
                <td class="px-6 py-4 text-center">
                    <div class="flex justify-center space-x-3">
                        <button data-action="edit" data-producto-id="${
                            producto.id
                        }" 
                                class="text-[#1A323E] dark:text-white hover:text-[#F3C71E] transition-colors">
                            <i class="fas fa-edit mr-1"></i>Editar
                        </button>
                        <button data-action="delete" data-producto-id="${
                            producto.id
                        }" 
                                class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 transition-colors">
                            <i class="fas fa-trash-alt mr-1"></i>Eliminar
                        </button>
                    </div>
                </td>
            </tr>
        `;
    }

    getStockClass(stock) {
        if (stock === 0)
            return "bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400";
        if (stock <= 5)
            return "bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400";
        return "bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400";
    }

    getEstadoClass(stock) {
        if (stock === 0)
            return "bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400";
        return "bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400";
    }

    formatPrice(price) {
        return new Intl.NumberFormat("es-ES", {
            style: "currency",
            currency: "EUR",
        }).format(price);
    }

    showSuccess(message) {
        const alert = document.createElement("div");
        alert.className =
            "bg-green-100 dark:bg-green-900/30 border border-green-400 text-green-700 dark:text-green-400 px-4 py-3 rounded relative mb-4";
        alert.innerHTML = `<span class="block sm:inline">${message}</span>`;
        this.container.insertBefore(alert, this.container.firstChild);
        setTimeout(() => alert.remove(), 3000);
    }

    showError(message) {
        const alert = document.createElement("div");
        alert.className =
            "bg-red-100 dark:bg-red-900/30 border border-red-400 text-red-700 dark:text-red-400 px-4 py-3 rounded relative mb-4";
        alert.innerHTML = `<span class="block sm:inline">${message}</span>`;
        this.container.insertBefore(alert, this.container.firstChild);
        setTimeout(() => alert.remove(), 3000);
    }
}

export default ProductosTable;
