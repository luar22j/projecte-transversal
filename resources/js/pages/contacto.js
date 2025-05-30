$(document).ready(function () {
    // Función para capitalizar palabras
    function capitalizeWords(str) {
        return str.replace(/\b\w/g, function (l) {
            return l.toUpperCase();
        });
    }

    // Función para validar el formulario
    function validateForm() {
        let isValid = true;
        const form = $("form");
        const errors = {};

        // Validar campos requeridos
        form.find("input[required], textarea[required]").each(function () {
            if (!$(this).val()) {
                isValid = false;
                errors[$(this).attr("name")] = ["Este campo es obligatorio"];
            }
        });

        // Validar email si no está logueado
        if ($("#email").length) {
            const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!emailRegex.test($("#email").val())) {
                isValid = false;
                errors.email = ["El email debe ser válido"];
            }
        }

        // Validar nombre y apellidos si no está logueado
        if ($("#nombre").length) {
            const nameRegex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,}$/;
            if (!nameRegex.test($("#nombre").val())) {
                isValid = false;
                errors.nombre = [
                    "El nombre solo puede contener letras y espacios",
                ];
            }
            if (!nameRegex.test($("#apellidos").val())) {
                isValid = false;
                errors.apellidos = [
                    "Los apellidos solo pueden contener letras y espacios",
                ];
            }
        }

        // Validar consulta
        if ($("#consulta").val().length > 150) {
            isValid = false;
            errors.consulta = [
                "La consulta no puede tener más de 150 caracteres",
            ];
        }

        // Mostrar errores
        $(".error-message").remove();
        Object.keys(errors).forEach((field) => {
            const input = $(`[name="${field}"]`);
            input.addClass("is-invalid");
            input.after(`<div class="error-message">${errors[field][0]}</div>`);
        });

        // Habilitar/deshabilitar botón
        $(".submit").prop("disabled", !isValid);
        return isValid;
    }

    // Eventos para los inputs
    $("input, textarea").on("input", function () {
        $(this).removeClass("is-invalid");
        $(".error-message").remove();

        // Capitalizar nombre y apellidos
        if (
            $(this).attr("id") === "nombre" ||
            $(this).attr("id") === "apellidos"
        ) {
            $(this).val(capitalizeWords($(this).val()));
        }

        validateForm();
    });

    // Contador de caracteres para la consulta
    $("#consulta").on("input", function () {
        const maxLength = 150;
        const currentLength = $(this).val().length;
        $("#char-count").text(currentLength);

        if (currentLength > maxLength) {
            $(this).val($(this).val().substring(0, maxLength));
        }

        validateForm();
    });

    // Envío del formulario
    $("form").on("submit", function (e) {
        e.preventDefault();

        if (!validateForm()) {
            return;
        }

        // Mostrar spinner
        $(".spinner-container").show();
        $(".submit").prop("disabled", true);

        // Enviar formulario
        $.ajax({
            url: $(this).attr("action"),
            method: "POST",
            data: $(this).serialize(),
            success: function (response) {
                if (response.success) {
                    // Mostrar mensaje de éxito
                    $(".form").html(`
                        <div class="success-message">
                            <h2>¡Consulta enviada!</h2>
                            <p>${response.message}</p>
                            <a href="/" class="button">Volver al inicio</a>
                        </div>
                    `);
                }
            },
            error: function (xhr) {
                // Mostrar errores
                const errors = xhr.responseJSON.errors;
                Object.keys(errors).forEach((field) => {
                    const input = $(`[name="${field}"]`);
                    input.addClass("is-invalid");
                    input.after(
                        `<div class="error-message">${errors[field][0]}</div>`
                    );
                });

                // Ocultar spinner y habilitar botón
                $(".spinner-container").hide();
                $(".submit").prop("disabled", false);
            },
        });
    });

    // Validación inicial
    validateForm();
});
