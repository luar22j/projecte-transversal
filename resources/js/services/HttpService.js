import axios from "axios";

class HttpService {
    constructor() {
        this.axios = axios.create({
            baseURL: "/api",
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    ?.getAttribute("content"),
            },
            withCredentials: true,
        });

        // Interceptor para manejar errores
        this.axios.interceptors.response.use(
            (response) => response,
            (error) => {
                if (error.response && error.response.status === 401) {
                    window.location.href = "/login";
                }
                return Promise.reject(error);
            }
        );
    }

    async get(url, params = {}) {
        try {
            const response = await this.axios.get(url, { params });
            return response.data;
        } catch (error) {
            this.handleError(error);
        }
    }

    async post(url, data = {}) {
        try {
            const response = await this.axios.post(url, data);
            return response.data;
        } catch (error) {
            this.handleError(error);
        }
    }

    async put(url, data = {}) {
        try {
            const response = await this.axios.put(url, data);
            return response.data;
        } catch (error) {
            this.handleError(error);
        }
    }

    async delete(url) {
        try {
            const response = await this.axios.delete(url);
            return response.data;
        } catch (error) {
            this.handleError(error);
        }
    }

    handleError(error) {
        if (error.response) {
            const { status, data } = error.response;
            switch (status) {
                case 401:
                    window.location.href = "/login";
                    break;
                case 403:
                    window.location.href = "/";
                    break;
                case 422:
                    throw new Error(data.message || "Error de validación");
                default:
                    throw new Error(data.message || "Error del servidor");
            }
        }
        throw error;
    }
}

export default new HttpService();
