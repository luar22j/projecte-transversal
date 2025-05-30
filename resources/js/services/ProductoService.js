import HttpService from "./HttpService";

class ProductoService {
    async getProductos(params = {}) {
        return await HttpService.get("/productos", params);
    }

    async createProducto(productoData) {
        return await HttpService.post("/productos", productoData);
    }

    async updateProducto(productoId, productoData) {
        return await HttpService.put(`/productos/${productoId}`, productoData);
    }

    async deleteProducto(productoId) {
        return await HttpService.delete(`/productos/${productoId}`);
    }

    async getProducto(productoId) {
        return await HttpService.get(`/productos/${productoId}`);
    }

    async getCategorias() {
        return await HttpService.get("/categorias");
    }

    async getSubcategorias(categoriaId) {
        return await HttpService.get(
            `/categorias/${categoriaId}/subcategorias`
        );
    }
}

export default new ProductoService();
