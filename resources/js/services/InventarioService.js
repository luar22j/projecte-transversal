import HttpService from "./HttpService";

class InventarioService {
    async getProductos(params = {}) {
        return await HttpService.get("/inventario", params);
    }

    async getProductosAgotados() {
        return await HttpService.get("/inventario/agotados");
    }

    async getProductosMasVendidos() {
        return await HttpService.get("/inventario/mas-vendidos");
    }

    async ordenarProductos(campo, orden) {
        return await HttpService.get(`/inventario/ordenar/${campo}/${orden}`);
    }

    async actualizarStock(productoId, stock) {
        return await HttpService.post(
            `/inventario/actualizar-stock/${productoId}`,
            { stock }
        );
    }
}

export default new InventarioService();
