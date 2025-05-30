document.addEventListener("DOMContentLoaded", function () {
    const themeToggle = document.getElementById("themeToggle");
    const body = document.body;

    // Función para aplicar el tema
    function applyTheme(theme) {
        if (theme === "light") {
            body.classList.add("light-mode");
        } else {
            body.classList.remove("light-mode");
        }
    }

    // Función para cambiar el tema
    function toggleTheme() {
        const isLightMode = body.classList.contains("light-mode");
        const newTheme = isLightMode ? "dark" : "light";

        // Guardar preferencia en localStorage
        localStorage.setItem("theme", newTheme);

        // Aplicar el nuevo tema
        applyTheme(newTheme);
    }

    // Aplicar tema guardado al cargar la página
    const savedTheme = localStorage.getItem("theme");
    if (savedTheme) {
        applyTheme(savedTheme);
    }

    // Añadir evento al botón
    if (themeToggle) {
        themeToggle.addEventListener("click", toggleTheme);
    } else {
        console.error("No se encontró el botón de tema");
    }
});
