function toggleDropdown(dropdownId, iconId) {
    const dropdown = document.getElementById(dropdownId);
    const icon = document.getElementById(iconId);
    const isHidden = dropdown.classList.contains("hidden");

    ["filtrarDropdown", "ordenarDropdown"].forEach((id) => {
        const d = document.getElementById(id);
        const i = document.getElementById(id.replace("Dropdown", "Icon"));
        if (d !== dropdown) {
            d.classList.add("hidden", "opacity-0", "scale-95");
            i?.classList.remove("rotate-180");
        }
    });

    if (isHidden) {
        dropdown.classList.remove("hidden");
        setTimeout(() => {
            dropdown.classList.remove("opacity-0", "scale-95");
            icon?.classList.add("rotate-180");
        }, 10);
    } else {
        dropdown.classList.add("opacity-0", "scale-95");
        icon?.classList.remove("rotate-180");
        setTimeout(() => {
            dropdown.classList.add("hidden");
        }, 200);
    }
}

document.getElementById("filtrarBtn")?.addEventListener("click", () => {
    toggleDropdown("filtrarDropdown", "filtrarIcon");
});

document.getElementById("ordenarBtn")?.addEventListener("click", () => {
    toggleDropdown("ordenarDropdown", "ordenarIcon");
});

window.addEventListener("click", (event) => {
    if (
        !event.target.closest("#filtrarBtn") &&
        !event.target.closest("#ordenarBtn")
    ) {
        ["filtrarDropdown", "ordenarDropdown"].forEach((id) => {
            const dropdown = document.getElementById(id);
            const icon = document.getElementById(
                id.replace("Dropdown", "Icon")
            );
            dropdown?.classList.add("hidden", "opacity-0", "scale-95");
            icon?.classList.remove("rotate-180");
        });
    }
});

document
    .getElementById("burgers-link")
    ?.addEventListener("click", function (event) {
        event.stopPropagation();
        return true;
    });

document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("productSearch");
    const clearButton = document.getElementById("clearSearch");
    const searchIcon = document.getElementById("searchIcon");
    if (!searchInput || !clearButton || !searchIcon) return;

    let searchTimeout;

    // Función para limpiar la búsqueda
    function clearSearch() {
        searchInput.value = "";
        clearButton.classList.add("hidden");
        searchIcon.classList.remove("hidden");
        const productsContainer = document.querySelector(".lg\\:col-span-3");
        const productCards = productsContainer.querySelectorAll(
            "div.flex.flex-col.gap-2"
        );
        const existingMessage = document.querySelector(".no-results-message");

        if (existingMessage) {
            existingMessage.remove();
        }

        productCards.forEach((card) => {
            card.style.display = "";
        });
    }

    // Evento para el botón de limpiar
    clearButton.addEventListener("click", clearSearch);

    searchInput.addEventListener("input", function (e) {
        clearTimeout(searchTimeout);
        const searchTerm = e.target.value.trim().toLowerCase();

        // Mostrar/ocultar los botones
        if (searchTerm) {
            clearButton.classList.remove("hidden");
            searchIcon.classList.add("hidden");
        } else {
            clearButton.classList.add("hidden");
            searchIcon.classList.remove("hidden");
        }

        searchTimeout = setTimeout(() => {
            const productsContainer =
                document.querySelector(".lg\\:col-span-3");
            const productCards = productsContainer.querySelectorAll(
                "div.flex.flex-col.gap-2"
            );
            let foundResults = false;

            // Primero, ocultar el mensaje de no resultados si existe
            const existingMessage = document.querySelector(
                ".no-results-message"
            );
            if (existingMessage) {
                existingMessage.remove();
            }

            // Si el término de búsqueda está vacío, mostrar todos los productos
            if (searchTerm === "") {
                productCards.forEach((card) => {
                    card.style.display = "";
                });
                return;
            }

            // Filtrar los productos
            productCards.forEach((card) => {
                const productName =
                    card.querySelector("h2")?.textContent.toLowerCase() || "";

                if (productName.includes(searchTerm)) {
                    card.style.display = "";
                    foundResults = true;
                } else {
                    card.style.display = "none";
                }
            });

            // Mostrar mensaje si no hay resultados
            if (!foundResults) {
                const noResultsMessage = document.createElement("div");
                noResultsMessage.className =
                    "no-results-message w-full text-center py-8";
                noResultsMessage.innerHTML = `
                    <div class="flex flex-col items-center gap-4">
                        <i class="fas fa-search text-4xl text-gray-300"></i>
                        <h3 class="text-xl font-semibold text-gray-300">No se encontraron productos</h3>
                        <p class="text-gray-500">Intenta buscar con otro término</p>
                    </div>
                `;
                productsContainer.appendChild(noResultsMessage);
            }
        }, 300);
    });
});
