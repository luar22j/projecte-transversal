import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/css/pages/home.css",
                "resources/js/app.js",
                "resources/js/components/header.js",
                "resources/js/register-validation.js",
                "resources/css/auth/register.css",
                "resources/css/auth/login.css",
                "resources/js/auth/signUpValidation.js",
                "resources/js/auth/signInValidation.js",
                "public/js/services/HttpService.js",
                "public/js/services/UserService.js",
                "public/js/services/ProductoService.js",
                "public/js/services/InventarioService.js",
                "public/js/components/UsersTable.js",
                "public/js/components/ProductosTable.js",
                "public/js/pages/users.js",
                "public/js/pages/productos.js",
                "public/js/pages/inventario.js",
                "resources/js/productos.js",
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            "@": "/resources/js",
            "~": "/public/js",
        },
    },
    server: {
        hmr: {
            host: "localhost",
        },
    },
});
