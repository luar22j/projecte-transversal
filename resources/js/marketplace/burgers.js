window.mostrarIngredientes = function () {
    const modal = document.getElementById("ingredientesModal");
    const modalContent = modal.querySelector(".bg-white");

    document.body.style.overflow = "hidden";
    modal.classList.remove("opacity-0", "pointer-events-none");
    modal.classList.add("flex", "opacity-100");

    modalContent.classList.add("scale-95");

    setTimeout(() => {
        modalContent.classList.remove("scale-95");
        modalContent.classList.add("scale-100");
    }, 10);
};

window.cerrarModal = function () {
    const modal = document.getElementById("ingredientesModal");
    const modalContent = modal.querySelector(".bg-white");

    modalContent.classList.remove("scale-100");
    modalContent.classList.add("scale-95");

    modal.classList.remove("opacity-100");
    modal.classList.add("opacity-0");

    setTimeout(() => {
        modal.classList.remove("flex");
        modal.classList.add("pointer-events-none");
        document.body.style.overflow = "";
    }, 300);
};

document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("ingredientesModal");

    modal.addEventListener("click", function (e) {
        if (e.target === this) {
            cerrarModal();
        }
    });

    modal.classList.add("opacity-0", "pointer-events-none");
    modal.classList.remove("flex");

    const modalContent = modal.querySelector(".bg-white");
    if (modalContent) {
        modalContent.addEventListener("wheel", function (e) {
            const scrollTop = modalContent.scrollTop;
            const scrollHeight = modalContent.scrollHeight;
            const height = modalContent.clientHeight;

            if (
                (scrollTop === 0 && e.deltaY < 0) ||
                (scrollTop + height === scrollHeight && e.deltaY > 0)
            ) {
                e.preventDefault();
            }
        });
    }
});
