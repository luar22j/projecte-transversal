document.addEventListener("DOMContentLoaded", function () {
    // Función para limpiar el carrito
    function limpiarCarrito() {
        localStorage.removeItem("cart");
        window.location.href = "/carrito";
    }

    // Función para obtener los items del carrito
    function obtenerItemsCarrito() {
        return JSON.parse(localStorage.getItem("cart")) || [];
    }

    // Función para formatear el precio
    const formatPrice = (price) => {
        return `€${price.toFixed(2)}`;
    };

    // Obtener los items del carrito
    const cartItems = obtenerItemsCarrito();
    const cartItemsContainer = document.getElementById("cart-items");
    const cartTotal = document.getElementById("cart-total");
    const paymentAmount = document.getElementById("payment-amount");

    let total = 0;

    // Renderizar los items del carrito
    if (cartItems.length === 0) {
        cartItemsContainer.innerHTML = `
            <div class="empty-cart flex flex-col items-center justify-center">
                <p class="text-white text-center mb-4">Tu carrito está vacío</p>
                <a href="/marketplace" class="bg-[#F3C71E] hover:bg-[#f4cf3c] text-[#1A323E] rounded-full px-6 py-2 font-semibold transition-colors inline-block">Ir a la tienda</a>
            </div>
        `;
        cartTotal.textContent = formatPrice(0);
        paymentAmount.textContent = formatPrice(0);
        return;
    }

    const itemsHtml = cartItems
        .map((item) => {
            const itemTotal = item.price * item.quantity;
            total += itemTotal;
            return `
            <div class="flex items-center gap-4 py-2 border-b border-white cart-item">
                <img src="http://127.0.0.1:8000/images/${item.image}" alt="${
                item.name
            }" class="h-16 object-cover rounded-lg">
                <div class="flex-1 min-w-0">
                    <h3 class="text-lg font-semibold text-white">${
                        item.name
                    }</h3>
                    <p class="text-gray-300 text-sm">Precio: ${formatPrice(
                        item.price
                    )}</p>
                    <p class="text-gray-300 text-sm">Cantidad: ${
                        item.quantity
                    }</p>
                </div>
                <div class="text-right">
                    <p class="text-lg font-semibold text-white">${formatPrice(
                        itemTotal
                    )}</p>
                </div>
            </div>
        `;
        })
        .join("");

    cartItemsContainer.innerHTML = itemsHtml;

    // Actualizar los totales
    cartTotal.textContent = formatPrice(total);
    paymentAmount.textContent = formatPrice(total);

    // Manejar el envío del formulario
    const paymentForm = document.getElementById("payment-form");
    if (paymentForm) {
        paymentForm.addEventListener("submit", handleSubmit);
    }

    // Formatear número de tarjeta
    const numeroInput = document.getElementById("numero");
    if (numeroInput) {
        numeroInput.addEventListener("input", function (e) {
            let value = e.target.value.replace(/\D/g, "");
            if (value.length > 16) value = value.slice(0, 16);
            e.target.value = value;
        });
    }

    // Formatear fecha de expiración
    const expiracionInput = document.getElementById("expiracion");
    if (expiracionInput) {
        expiracionInput.addEventListener("input", function (e) {
            let value = e.target.value.replace(/\D/g, "");
            if (value.length >= 2) {
                value = value.slice(0, 2) + "/" + value.slice(2, 4);
            }
            e.target.value = value;
        });
    }

    // Formatear CVV
    const cvvInput = document.getElementById("cvv");
    if (cvvInput) {
        cvvInput.addEventListener("input", function (e) {
            let value = e.target.value.replace(/\D/g, "");
            if (value.length > 3) value = value.slice(0, 3);
            e.target.value = value;
        });
    }

    // Función para validar el número de tarjeta
    function validarNumeroTarjeta(numero) {
        if (!numero) {
            throw new Error("El número de tarjeta es obligatorio");
        }
        if (numero.length !== 16) {
            throw new Error("El número de tarjeta debe tener 16 dígitos");
        }
        if (!/^\d+$/.test(numero)) {
            throw new Error("El número de tarjeta solo debe contener números");
        }
        return true;
    }

    // Función para validar la fecha de expiración
    function validarFechaExpiracion(fecha) {
        if (!fecha) {
            throw new Error("La fecha de expiración es obligatoria");
        }
        if (!/^\d{2}\/\d{2}$/.test(fecha)) {
            throw new Error(
                "La fecha de expiración debe tener el formato MM/YY"
            );
        }
        const [mes, anio] = fecha.split("/");
        const mesActual = new Date().getMonth() + 1;
        const anioActual = new Date().getFullYear() % 100;

        if (parseInt(mes) < 1 || parseInt(mes) > 12) {
            throw new Error("El mes debe estar entre 01 y 12");
        }

        if (
            parseInt(anio) < anioActual ||
            (parseInt(anio) === anioActual && parseInt(mes) < mesActual)
        ) {
            throw new Error("La tarjeta ha expirado");
        }
        return true;
    }

    // Función para validar el CVV
    function validarCVV(cvv) {
        if (!cvv) {
            throw new Error("El CVV es obligatorio");
        }
        if (cvv.length !== 3) {
            throw new Error("El CVV debe tener 3 dígitos");
        }
        if (!/^\d+$/.test(cvv)) {
            throw new Error("El CVV solo debe contener números");
        }
        return true;
    }

    // Función para mostrar errores
    function mostrarError(campo, mensaje) {
        const input = document.getElementById(campo);
        const errorDiv = document.createElement("div");
        errorDiv.className = "text-red-500 text-sm mt-1";
        errorDiv.textContent = mensaje;

        // Eliminar mensaje de error anterior si existe
        const errorAnterior =
            input.parentElement.querySelector(".text-red-500");
        if (errorAnterior) {
            errorAnterior.remove();
        }

        input.classList.add("border-red-500");
        input.parentElement.appendChild(errorDiv);
    }

    // Función para limpiar errores
    function limpiarError(campo) {
        const input = document.getElementById(campo);
        const errorDiv = input.parentElement.querySelector(".text-red-500");
        if (errorDiv) {
            errorDiv.remove();
        }
        input.classList.remove("border-red-500");
    }

    // Función para validar todo el formulario
    function validarFormulario() {
        let hayErrores = false;
        const campos = {
            numero: validarNumeroTarjeta,
            expiracion: validarFechaExpiracion,
            cvv: validarCVV,
        };

        // Limpiar todos los errores anteriores
        Object.keys(campos).forEach((campo) => limpiarError(campo));

        // Validar cada campo
        Object.entries(campos).forEach(([campo, validacion]) => {
            try {
                const valor = document.getElementById(campo).value;
                validacion(valor);
            } catch (error) {
                mostrarError(campo, error.message);
                hayErrores = true;
            }
        });

        return !hayErrores;
    }

    // Añadir event listeners para limpiar errores al escribir
    ["numero", "expiracion", "cvv"].forEach((campo) => {
        const input = document.getElementById(campo);
        if (input) {
            input.addEventListener("input", () => limpiarError(campo));
        }
    });

    // Modificar el handleSubmit para incluir validaciones
    function handleSubmit(e) {
        e.preventDefault();

        // Validar el formulario antes de continuar
        if (!validarFormulario()) {
            return;
        }

        const form = e.target;
        const submitButton = form.querySelector('button[type="submit"]');
        submitButton.disabled = true;
        submitButton.innerHTML = "Procesando...";

        const formData = new FormData(form);
        const cartItems = obtenerItemsCarrito();

        if (cartItems.length === 0) {
            alert("El carrito está vacío");
            submitButton.disabled = false;
            submitButton.innerHTML = `Pagar <span id="payment-amount">${formatPrice(
                total
            )}</span>`;
            return;
        }

        // Preparar los items para el servidor
        const items = cartItems.map((item) => ({
            id: item.id,
            quantity: item.quantity,
            price: item.price,
        }));

        // Calcular el total
        const total = items.reduce(
            (sum, item) => sum + item.price * item.quantity,
            0
        );

        formData.append("items", JSON.stringify(items));
        formData.append("total", total);

        // Enviar el formulario
        fetch(form.action, {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
            },
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    // Limpiar el carrito y redirigir
                    limpiarCarrito();
                    window.location.href = data.redirect;
                } else {
                    throw new Error(
                        data.message || "Error al procesar el pago"
                    );
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                alert(error.message || "Error al procesar el pago");
                submitButton.disabled = false;
                submitButton.innerHTML = `Pagar <span id="payment-amount">${formatPrice(
                    total
                )}</span>`;
            });
    }
});

function loadCartItems() {
    fetch("/carrito/items")
        .then((response) => response.json())
        .then((data) => {
            const cartItems = document.getElementById("cart-items");
            const cartTotal = document.getElementById("cart-total");
            const paymentAmount = document.getElementById("payment-amount");

            if (cartItems) {
                cartItems.innerHTML = data.items
                    .map(
                        (item) => `
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-white">${item.producto.nombre} x ${
                            item.cantidad
                        }</span>
                        <span class="text-white">€${(
                            item.precio_unitario * item.cantidad
                        ).toFixed(2)}</span>
                    </div>
                `
                    )
                    .join("");
            }

            if (cartTotal) {
                cartTotal.textContent = `€${data.total.toFixed(2)}`;
            }

            if (paymentAmount) {
                paymentAmount.textContent = `€${data.total.toFixed(2)}`;
            }
        })
        .catch((error) => console.error("Error:", error));
}
