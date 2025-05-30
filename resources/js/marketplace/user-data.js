// Variable global para almacenar los datos del usuario
let userData = null;

// Función para obtener los datos del usuario
async function obtenerDatosUsuario() {
    if (userData) {
        return userData;
    }

    try {
        const token = document.querySelector(
            'meta[name="csrf-token"]'
        )?.content;

        const response = await fetch("/user-data", {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN": token,
            },
            credentials: "same-origin",
        });

        if (response.ok) {
            userData = await response.json();
            return userData;
        } else {
            console.error("Error en la respuesta:", response.status);
            const errorText = await response.text();
            console.error("Detalles del error:", errorText);
        }
    } catch (error) {
        console.error("Error al obtener datos del usuario:", error);
    }
    return null;
}

// Función para rellenar los campos del formulario con los datos del usuario
function rellenarCamposUsuario(form) {
    if (!userData) {
        return;
    }

    const nombreInput = form.querySelector("#nombre");
    const emailInput = form.querySelector("#email");

    if (nombreInput) {
        nombreInput.value = userData.name || "";
        nombreInput.readOnly = true;
        nombreInput.classList.add("bg-gray-100");
    }

    if (emailInput) {
        emailInput.value = userData.email || "";
        emailInput.readOnly = true;
        emailInput.classList.add("bg-gray-100");
    }
}

document.addEventListener("DOMContentLoaded", async () => {
    if (document.body.classList.contains("logged-in")) {
        await obtenerDatosUsuario();
    }
});

// Exportar las funciones para que estén disponibles globalmente
window.obtenerDatosUsuario = obtenerDatosUsuario;
window.rellenarCamposUsuario = rellenarCamposUsuario;
