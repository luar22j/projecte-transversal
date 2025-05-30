import axios from "axios";

// Configurar axios con los headers por defecto
const api = axios.create({
    headers: {
        "X-Requested-With": "XMLHttpRequest",
        Accept: "application/json",
        "Content-Type": "application/json",
    },
    withCredentials: true, // Importante para las cookies de sesión
});

// Interceptor para añadir el token CSRF a todas las peticiones
api.interceptors.request.use((config) => {
    const token = document
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute("content");
    if (token) {
        config.headers["X-CSRF-TOKEN"] = token;
    }
    return config;
});

export const marketplaceService = {
    getProducts: () => api.get("/api/productos"),
    getCategories: () => api.get("/api/categorias"),
    getSubcategories: (categoryId) =>
        api.get(`/api/categorias/${categoryId}/subcategorias`),
};

export const cartService = {
    getItems: () => api.get("/api/carrito/items"),
    addItem: (productId, quantity) =>
        api.post("/api/carrito", { product_id: productId, quantity }),
    updateItem: (cartId, quantity) =>
        api.put(`/api/carrito/${cartId}`, { quantity }),
    removeItem: (cartId) => api.delete(`/api/carrito/${cartId}`),
    clearCart: () => api.delete("/api/carrito"),
};

export const orderService = {
    getOrders: () => api.get("/api/cliente/pedidos"),
    getOrder: (orderId) => api.get(`/api/cliente/pedidos/${orderId}`),
    cancelOrder: (orderId) =>
        api.post(`/api/cliente/pedidos/${orderId}/cancelar`),
};

export const checkoutService = {
    processCheckout: (data) => api.post("/api/checkout", data),
};

export const authService = {
    login: (credentials) => api.post("/api/login", credentials),
    register: (userData) => api.post("/api/register", userData),
    logout: () => api.post("/api/logout"),
};

export default api;
