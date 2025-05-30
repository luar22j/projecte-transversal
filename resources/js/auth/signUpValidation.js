$(document).ready(function () {
    $("#nombre").on("input", function () {
        const regex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,}$/;
        if (!regex.test($(this).val())) {
            $(this).addClass("is-invalid");
        } else {
            $(this).removeClass("is-invalid");
        }
    });

    $("#apellidos").on("input", function () {
        const regex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,}$/;
        if (!regex.test($(this).val())) {
            $(this).addClass("is-invalid");
        } else {
            $(this).removeClass("is-invalid");
        }
    });

    $("#fecha_nacimiento").on("change", function () {
        const birthDate = new Date($(this).val());
        const today = new Date();
        let age = today.getFullYear() - birthDate.getFullYear();
        const monthDiff = today.getMonth() - birthDate.getMonth();

        if (
            monthDiff < 0 ||
            (monthDiff === 0 && today.getDate() < birthDate.getDate())
        ) {
            age--;
        }

        if (age < 18 || age > 100) {
            $(this).addClass("is-invalid");
        } else {
            $(this).removeClass("is-invalid");
        }
    });

    $("#telefono").on("input", function () {
        const regex = /^(\+?[0-9]{9,15})$/;
        const telefono = $(this).val();
        if (!regex.test(telefono)) {
            $(this).addClass("is-invalid");
        } else {
            $(this).removeClass("is-invalid");
        }
    });

    $("#email").on("input", function () {
        const regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!regex.test($(this).val())) {
            $(this).addClass("is-invalid");
        } else {
            $(this).removeClass("is-invalid");
        }
    });

    // Función para calcular la fortaleza de la contraseña
    function checkPasswordStrength(password) {
        let strength = 0;

        // Longitud mínima
        if (password.length >= 8) strength += 1;

        // Contiene números
        if (/\d/.test(password)) strength += 1;

        // Contiene letras minúsculas
        if (/[a-z]/.test(password)) strength += 1;

        // Contiene letras mayúsculas
        if (/[A-Z]/.test(password)) strength += 1;

        // Contiene caracteres especiales
        if (/[!@#$%^&*]/.test(password)) strength += 1;

        return strength;
    }

    // Función para actualizar el medidor de fortaleza
    function updatePasswordStrength(password) {
        const strength = checkPasswordStrength(password);
        const meter = document.getElementById("password-strength");
        const text = document.getElementById("strength-text");

        meter.value = strength;

        let message = "";
        let color = "";

        switch (strength) {
            case 0:
            case 1:
                message = "Muy débil";
                color = "red";
                break;
            case 2:
                message = "Débil";
                color = "orange";
                break;
            case 3:
                message = "Media";
                color = "yellow";
                break;
            case 4:
                message = "Fuerte";
                color = "lightgreen";
                break;
            case 5:
                message = "Muy fuerte";
                color = "green";
                break;
        }

        text.textContent = message;
        text.style.color = color;

        return strength >= 3; // Retorna true si la contraseña es de nivel medio o superior
    }

    $("#password").on("input", function () {
        const password = $(this).val();
        const isStrongEnough = updatePasswordStrength(password);

        if (!isStrongEnough) {
            $(this).addClass("is-invalid");
        } else {
            $(this).removeClass("is-invalid");
        }
    });

    $("#password_confirmation").on("input", function () {
        if ($(this).val() !== $("#password").val()) {
            $(this).addClass("is-invalid");
        } else {
            $(this).removeClass("is-invalid");
        }
    });

    // Manejar el checkbox de reutilizar dirección
    $("#reutilizar_direccion").on("change", function () {
        if ($(this).is(":checked")) {
            $("#direccion_facturacion").val($("#direccion_envio").val());
            $("#direccion_facturacion").prop("disabled", true);
        } else {
            $("#direccion_facturacion").prop("disabled", false);
        }
    });

    $("form").on("submit", function (e) {
        let isValid = true;
        $(this)
            .find("input[required], select[required]")
            .each(function () {
                if (!$(this).val()) {
                    $(this).addClass("is-invalid");
                    isValid = false;
                }
            });

        // Validar teléfono
        const telefonoRegex = /^(\+?[0-9]{9,15})$/;
        if (!telefonoRegex.test($("#telefono").val())) {
            $("#telefono").addClass("is-invalid");
            if (!$("#telefono").next(".invalid-feedback").length) {
                $("#telefono").after(
                    '<div class="invalid-feedback text-red-500">El número de teléfono debe tener entre 9 y 15 dígitos</div>'
                );
            }
            isValid = false;
        }

        // Verificar fortaleza de contraseña
        const passwordStrength = checkPasswordStrength($("#password").val());
        if (passwordStrength < 3) {
            $("#password").addClass("is-invalid");
            isValid = false;
        }

        // Verificar coincidencia de contraseñas
        if ($("#password").val() !== $("#password_confirmation").val()) {
            $("#password_confirmation").addClass("is-invalid");
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
            alert(
                "Por favor, corrige los errores en el formulario antes de continuar."
            );
        }
    });
});
