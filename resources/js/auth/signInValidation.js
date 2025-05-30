$(document).ready(function () {
    const email = document.getElementById("email");
    let emailError = true;
    email.addEventListener("input", () => {
        const regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        const s = email.value;
        if (regex.test(s)) {
            email.classList.remove("is-invalid");
            emailError = true;
        } else {
            email.classList.add("is-invalid");
            emailError = false;
        }
    });

    $("#passcheck").hide();
    let passwordError = true;
    const password = document.getElementById("password");
    password.addEventListener("input", () => {
        const regex =
            /^(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,}$/;
        if (regex.test(password.value)) {
            password.classList.remove("is-invalid");
            passwordError = true;
        } else {
            password.classList.add("is-invalid");
            passwordError = false;
        }
    });

    $("#submitbtn").click(function () {
        validatePassword();
        validateConfirmPassword();
        email.dispatchEvent(new Event("input"));

        if (passwordError && confirmPasswordError && emailError) {
            return true;
        } else {
            return false;
        }
    });

    $("form").on("submit", function (e) {
        e.preventDefault();

        if (passwordError && emailError) {
            // Aquí puedes enviar el formulario
            this.submit();
        }
    });
});
