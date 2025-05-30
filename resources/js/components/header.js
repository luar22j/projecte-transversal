function toggleMenu() {
    const nav = document.getElementById("mainNav");
    const menuIcon = document.getElementById("menuIcon");

    nav.classList.toggle("hidden");
    menuIcon.classList.toggle("rotate-90");

    if (!nav.classList.contains("hidden")) {
        setTimeout(() => {
            nav.classList.remove("opacity-0", "-translate-y-2");
            nav.classList.add("opacity-100", "translate-y-0");
        }, 10);
    } else {
        nav.classList.add("opacity-0", "-translate-y-2");
        nav.classList.remove("opacity-100", "translate-y-0");
    }
}

window.addEventListener("resize", () => {
    const nav = document.getElementById("mainNav");
    if (window.innerWidth >= 768) {
        nav.classList.remove("hidden");
        nav.classList.remove("opacity-0", "-translate-y-2");
        nav.classList.add("opacity-100", "translate-y-0");
    }
});

window.toggleMenu = toggleMenu;

document.addEventListener("DOMContentLoaded", () => {
    const menuToggleBtn = document.getElementById("menuToggleBtn");
    if (menuToggleBtn) {
        menuToggleBtn.addEventListener("click", toggleMenu);
    }
});
