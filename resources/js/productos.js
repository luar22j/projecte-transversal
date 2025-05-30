// Función para actualizar el stock de un producto
function updateStock(productoId, stock) {
    return axios
        .put(`/admin/ajax/productos/${productoId}/stock`, {
            stock: stock,
        })
        .then((response) => {
            if (response.data.success) {
                toastr.success(response.data.message);
                return response.data;
            }
        })
        .catch((error) => {
            toastr.error("Error al actualizar el stock");
            console.error(error);
        });
}

// Función para actualizar el precio de un producto
function updatePrecio(productoId, precio) {
    return axios
        .put(`/admin/ajax/productos/${productoId}/precio`, {
            precio: precio,
        })
        .then((response) => {
            if (response.data.success) {
                toastr.success(response.data.message);
                return response.data;
            }
        })
        .catch((error) => {
            toastr.error("Error al actualizar el precio");
            console.error(error);
        });
}

// Función para eliminar un producto
function deleteProducto(productoId) {
    if (confirm("¿Estás seguro de que deseas eliminar este producto?")) {
        return axios
            .delete(`/admin/ajax/productos/${productoId}`)
            .then((response) => {
                if (response.data.success) {
                    toastr.success(response.data.message);
                    // Eliminar la fila de la tabla
                    $(`#producto-${productoId}`).fadeOut(400, function () {
                        $(this).remove();
                    });
                    return response.data;
                }
            })
            .catch((error) => {
                toastr.error("Error al eliminar el producto");
                console.error(error);
            });
    }
}

// Función para actualizar la categoría de una subcategoría
function updateSubcategoriaCategoria(subcategoriaId, categoriaId) {
    return axios
        .put(`/admin/ajax/subcategorias/${subcategoriaId}/categoria`, {
            categoria_id: categoriaId,
        })
        .then((response) => {
            if (response.data.success) {
                toastr.success(response.data.message);
                return response.data;
            }
        })
        .catch((error) => {
            toastr.error("Error al actualizar la categoría");
            console.error(error);
        });
}

// Eventos para los inputs de stock
$(document).on("change", ".stock-input", function () {
    const productoId = $(this).data("producto-id");
    const stock = $(this).val();
    updateStock(productoId, stock);
});

// Eventos para los inputs de precio
$(document).on("change", ".precio-input", function () {
    const productoId = $(this).data("producto-id");
    const precio = $(this).val();
    updatePrecio(productoId, precio);
});

// Eventos para los botones de eliminar
$(document).on("click", ".delete-producto", function () {
    const productoId = $(this).data("producto-id");
    deleteProducto(productoId);
});

// Eventos para los selectores de categoría
$(document).on("change", ".categoria-select", function () {
    const subcategoriaId = $(this).data("subcategoria-id");
    const categoriaId = $(this).val();
    updateSubcategoriaCategoria(subcategoriaId, categoriaId);
});
