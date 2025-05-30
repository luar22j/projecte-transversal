function incrementarCantidad(button) {
    const input = button.parentElement.querySelector("input[type=number]");
    input.value = parseInt(input.value) + 1;
}

function decrementarCantidad(button) {
    const input = button.parentElement.querySelector("input[type=number]");
    if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
    }
}

// Función para cargar las opiniones de un producto
async function cargarOpiniones(productoId) {
    try {
        const response = await fetch(
            `http://localhost:8082/api/getOpinions/jpa/${productoId}`
        );
        const data = await response.json();

        return data.opinions.map((opinion) => ({
            puntuacion: opinion.rating,
            nombreUsuario: opinion.user,
            comentario: opinion.opinion,
            createdAt: opinion.timeStamp,
        }));
    } catch (error) {
        console.error("Error al cargar las opiniones:", error);
        return [];
    }
}

// Función para enviar una opinión
async function enviarOpinion(productoId, userId, puntuacion, comentario) {
    try {
        const response = await fetch("http://localhost:8082/api/sendOpinion", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
            },
            body: JSON.stringify({
                idProduct: productoId.toString(),
                idUser: userId.toString(),
                user: userId.toString(),
                rating: puntuacion,
                title: "Opinión de usuario",
                text: comentario,
            }),
        });

        // Si la respuesta es exitosa (status 200-299), consideramos que fue un éxito
        if (response.ok) {
            const data = await response.json();
            return true;
        }

        const errorData = await response.json();
        console.error("Error en la respuesta:", errorData);
        return false;
    } catch (error) {
        console.error("Error al enviar la opinión:", error);
        return false;
    }
}

// Función principal para mostrar detalles del producto
async function mostrarDetalles(
    nombre,
    precio,
    imagen,
    descripcion,
    ingredientes,
    productoId
) {
    let opiniones = [];
    try {
        opiniones = await cargarOpiniones(productoId);
    } catch (error) {
        console.error("Error al cargar opiniones:", error);
    }

    // Crear el modal
    const modal = document.createElement("div");
    modal.className =
        "fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50";
    modal.innerHTML = `
        <div class="bg-white p-6 rounded-xl mx-5 shadow-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-2xl text-[#1A323E] font-bold">${nombre}</h3>
                <button onclick="this.closest('.fixed').remove()" class="text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="flex flex-col md:flex-row gap-6">
                <div class="md:w-1/3">
                    <img src="/images/${imagen}" alt="${nombre}" class="w-full rounded-lg">
                </div>
                <div class="md:w-2/3">
                    <p class="text-gray-700 mb-4">${descripcion}</p>
                    ${
                        ingredientes.length > 0
                            ? `
                        <h4 class="font-semibold mb-2 text-[#1A323E]">Ingredientes:</h4>
                        <ul class="list-disc list-inside text-gray-700">
                            ${ingredientes
                                .map((ing) => `<li>${ing}</li>`)
                                .join("")}
                        </ul>
                    `
                            : ""
                    }
                    <p class="text-xl font-bold mt-4 text-[#1A323E]">${precio}</p>
                    
                    <!-- Sección de Opiniones -->
                    <div class="mt-6 border-t pt-6">
                        <h4 class="font-semibold mb-4 text-[#1A323E]">Opiniones</h4>
                        <div class="space-y-4">
                            ${
                                opiniones.length > 0
                                    ? opiniones
                                          .map(
                                              (op) => `
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <div class="flex items-center gap-2 mb-2">
                                            <div class="flex">
                                                ${Array(5)
                                                    .fill()
                                                    .map(
                                                        (_, i) => `
                                                    <i class="fas fa-star ${
                                                        i < op.puntuacion
                                                            ? "text-yellow-400"
                                                            : "text-gray-300"
                                                    }"></i>
                                                `
                                                    )
                                                    .join("")}
                                            </div>
                                            <span class="text-sm text-gray-600">por ${
                                                op.nombreUsuario
                                            }</span>
                                        </div>
                                        <p class="text-gray-700">${
                                            op.comentario
                                        }</p>
                                        <span class="text-xs text-gray-500">${new Date(
                                            op.createdAt
                                        ).toLocaleDateString()}</span>
                                    </div>
                                `
                                          )
                                          .join("")
                                    : '<p class="text-gray-500 text-center">No hay opiniones todavía. ¡Sé el primero en opinar!</p>'
                            }
                        </div>
                        
                        <!-- Formulario de Opinión -->
                        <div class="mt-6">
                            <h4 class="font-semibold mb-4 text-[#1A323E]">Deja tu opinión</h4>
                            <form id="opinionForm" class="space-y-4">
                                <div class="flex items-center gap-2">
                                    ${Array(5)
                                        .fill()
                                        .map(
                                            (_, i) => `
                                        <button type="button" class="text-2xl text-gray-300 hover:text-yellow-400 transition-colors" 
                                                onclick="seleccionarEstrella(this, ${
                                                    i + 1
                                                })">
                                            <i class="fas fa-star"></i>
                                        </button>
                                    `
                                        )
                                        .join("")}
                                </div>
                                <div>
                                    <label class="block text-gray-700 mb-2" for="comentario">Tu comentario</label>
                                    <textarea id="comentario" name="comentario" 
                                              class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1A323E] h-32" 
                                              required></textarea>
                                </div>
                                <button type="submit" 
                                        class="bg-[#1A323E] text-white px-6 py-2 rounded-lg hover:bg-[#2A4250] transition-colors">
                                    Enviar opinión
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <div class="mt-6 border-t pt-6">
                        <h4 class="font-semibold mb-4 text-[#1A323E]">Consulta sobre el producto</h4>
                        <form id="consultaForm" class="space-y-4">
                            <div id="camposIdentificacion">
                                <div class="mb-4">
                                    <label class="block text-gray-700 mb-2" for="nombre">Nombre y apellidos</label>
                                    <input type="text" id="nombre" name="nombre" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1A323E]" required>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-gray-700 mb-2" for="email">Email</label>
                                    <input type="email" id="email" name="email" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1A323E]" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 mb-2" for="referencia">Referencia del producto</label>
                                <input type="text" id="referencia" name="referencia" value="${nombre}" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1A323E]" readonly>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 mb-2" for="consulta">Consulta (máximo 150 caracteres)</label>
                                <textarea id="consulta" name="consulta" maxlength="150" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1A323E] h-32" required></textarea>
                                <div class="text-sm text-gray-500 mt-1">
                                    <span id="caracteresRestantes">150</span> caracteres restantes
                                </div>
                            </div>
                            <button type="submit" id="enviarConsulta" class="bg-[#1A323E] text-white px-6 py-2 rounded-lg hover:bg-[#2A4250] transition-colors disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                                Enviar consulta
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    `;
    document.body.appendChild(modal);

    // Inicializar el formulario de opinión
    const opinionForm = modal.querySelector("#opinionForm");
    let puntuacionSeleccionada = 0;

    window.seleccionarEstrella = (boton, puntuacion) => {
        const estrellas = opinionForm.querySelectorAll(".fa-star");
        puntuacionSeleccionada = puntuacion;

        estrellas.forEach((estrella, index) => {
            if (index < puntuacion) {
                estrella.classList.remove("text-gray-300");
                estrella.classList.add("text-yellow-400");
            } else {
                estrella.classList.remove("text-yellow-400");
                estrella.classList.add("text-gray-300");
            }
        });
    };

    opinionForm.addEventListener("submit", async (e) => {
        e.preventDefault();
        const comentario = opinionForm.querySelector("#comentario").value;

        if (puntuacionSeleccionada === 0) {
            alert("Por favor, selecciona una puntuación");
            return;
        }

        // Obtener el ID del usuario actual
        let userData;
        try {
            const response = await fetch("/user-data", {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                },
                credentials: "same-origin",
            });

            if (response.ok) {
                userData = await response.json();

                // Si tenemos datos del usuario, significa que está autenticado
                if (!userData || !userData.email) {
                    alert("Debes iniciar sesión para enviar una opinión");
                    return;
                }
            } else {
                alert("Debes iniciar sesión para enviar una opinión");
                return;
            }
        } catch (error) {
            console.error("Error al obtener datos del usuario:", error);
            alert("Error al obtener datos del usuario");
            return;
        }

        // Verificar que todos los campos necesarios estén presentes
        if (
            !productoId ||
            !userData.id ||
            !puntuacionSeleccionada ||
            !comentario
        ) {
            console.error("Faltan campos requeridos:", {
                productoId,
                userId: userData.id,
                puntuacionSeleccionada,
                comentario,
            });
            alert("Faltan datos necesarios para enviar la opinión");
            return;
        }

        const success = await enviarOpinion(
            productoId,
            userData.id,
            puntuacionSeleccionada,
            comentario
        );

        if (success) {
            alert("¡Gracias por tu opinión!");
            opinionForm.reset();
            puntuacionSeleccionada = 0;
            const estrellas = opinionForm.querySelectorAll(".fa-star");
            estrellas.forEach((estrella) => {
                estrella.classList.remove("text-yellow-400");
                estrella.classList.add("text-gray-300");
            });

            // Recargar opiniones
            try {
                const nuevasOpiniones = await cargarOpiniones(productoId);
                const opinionesContainer = modal.querySelector(".space-y-4");
                opinionesContainer.innerHTML = nuevasOpiniones
                    .map(
                        (op) => `
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="flex">
                                ${Array(5)
                                    .fill()
                                    .map(
                                        (_, i) => `
                                    <i class="fas fa-star ${
                                        i < op.puntuacion
                                            ? "text-yellow-400"
                                            : "text-gray-300"
                                    }"></i>
                                `
                                    )
                                    .join("")}
                            </div>
                            <span class="text-sm text-gray-600">por ${
                                op.nombreUsuario
                            }</span>
                        </div>
                        <p class="text-gray-700">${op.comentario}</p>
                        <span class="text-xs text-gray-500">${new Date(
                            op.createdAt
                        ).toLocaleDateString()}</span>
                    </div>
                `
                    )
                    .join("");
            } catch (error) {
                console.error("Error al recargar opiniones:", error);
            }
        } else {
            alert(
                "Hubo un error al enviar tu opinión. Por favor, inténtalo de nuevo."
            );
        }
    });

    // Inicializar el formulario de consulta
    const form = modal.querySelector("#consultaForm");
    const consultaInput = form.querySelector("#consulta");
    const caracteresRestantes = form.querySelector("#caracteresRestantes");
    const enviarBtn = form.querySelector("#enviarConsulta");
    // Verificar si el usuario está logueado
    const isLoggedIn = document.body.classList.contains("logged-in");
    if (isLoggedIn) {
        // Mostrar loader en los campos
        const nombreInput = form.querySelector("#nombre");
        const emailInput = form.querySelector("#email");

        if (nombreInput && emailInput) {
            // Añadir loader dentro del input
            const loaderHTML = `
                <div class="absolute right-2 top-1/2 -translate-y-1/2">
                    <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-[#1A323E]"></div>
                </div>
            `;

            // Hacer los inputs relativos para posicionar el loader
            nombreInput.style.position = "relative";
            emailInput.style.position = "relative";

            // Añadir padding-right para el loader
            nombreInput.style.paddingRight = "2rem";
            emailInput.style.paddingRight = "2rem";

            // Deshabilitar inputs y añadir loader
            nombreInput.disabled = true;
            emailInput.disabled = true;

            // Crear contenedor para el input y el loader
            const nombreContainer = document.createElement("div");
            const emailContainer = document.createElement("div");
            nombreContainer.style.position = "relative";
            emailContainer.style.position = "relative";

            // Reemplazar los inputs con los contenedores
            nombreInput.parentNode.insertBefore(nombreContainer, nombreInput);
            emailInput.parentNode.insertBefore(emailContainer, emailInput);
            nombreContainer.appendChild(nombreInput);
            emailContainer.appendChild(emailInput);

            // Añadir el loader
            nombreContainer.insertAdjacentHTML("beforeend", loaderHTML);
            emailContainer.insertAdjacentHTML("beforeend", loaderHTML);
        }

        // Obtener datos del usuario
        try {
            const response = await fetch("/user-data", {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                },
                credentials: "same-origin",
            });

            if (response.ok) {
                const userData = await response.json();

                // Rellenar los campos
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
            } else {
                console.error(
                    "Error al obtener datos del usuario:",
                    response.status
                );
            }
        } catch (error) {
            console.error("Error en la petición:", error);
        } finally {
            // Eliminar loaders
            const loaders = form.querySelectorAll(".animate-spin");
            loaders.forEach((loader) => loader.parentElement.remove());

            // Restaurar estilos
            if (nombreInput) {
                nombreInput.disabled = false;
                nombreInput.style.paddingRight = "";
            }
            if (emailInput) {
                emailInput.disabled = false;
                emailInput.style.paddingRight = "";
            }
        }
    }

    // Actualizar caracteres restantes
    consultaInput.addEventListener("input", function () {
        const restantes = 150 - this.value.length;
        caracteresRestantes.textContent = restantes;
        validarFormulario();
    });

    // Validar formulario
    function validarFormulario() {
        const nombre = form.querySelector("#nombre").value;
        const email = form.querySelector("#email").value;
        const consulta = consultaInput.value;

        const emailValido = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        const formularioValido =
            (!isLoggedIn ? nombre && emailValido : true) && consulta.length > 0;

        enviarBtn.disabled = !formularioValido;
    }

    // Añadir validación en tiempo real
    form.querySelectorAll("input, textarea").forEach((input) => {
        input.addEventListener("input", validarFormulario);
    });

    // Manejar envío del formulario
    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        // Mostrar spinner
        enviarBtn.innerHTML = `
            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Enviando...
        `;
        enviarBtn.disabled = true;

        // Simular envío
        await new Promise((resolve) => setTimeout(resolve, 2000));

        // Mostrar mensaje de éxito
        form.innerHTML = `
            <div class="text-center py-4">
                <svg class="mx-auto h-12 w-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">Consulta enviada</h3>
                <p class="mt-1 text-sm text-gray-500">Gracias por tu consulta. Te responderemos lo antes posible.</p>
            </div>
        `;
    });
}

// Exportar las funciones para que estén disponibles globalmente
window.incrementarCantidad = incrementarCantidad;
window.decrementarCantidad = decrementarCantidad;
window.mostrarDetalles = mostrarDetalles;
