
document.addEventListener("DOMContentLoaded", () => {

    const navbar = document.getElementById("navbar");
    const sidebar = document.getElementById("sidebar");
    const dropdowns = document.querySelectorAll(".dropdown");
    const products = document.querySelectorAll(".navbar-products");
    const cartCounts = document.querySelectorAll(".cart-section .total-items");

    navbar.addEventListener("click", (event) => {
        sidebar.classList.contains("hidden") ? document.body.style.overflowY = "hidden" : document.body.style.overflowY = "auto";
        sidebar.classList.toggle("hidden");
        event.stopPropagation();
    })

    dropdowns.forEach(dropdown => {
        dropdown.addEventListener("click", (event) => {
            const menu = dropdown.querySelector(".dropdown-menu");
            if (menu.contains(event.target)) return;
            menu.classList.toggle("hidden");
            event.stopPropagation();
        })
    })

    document.body.addEventListener("click", (event) => {
        if (!sidebar.classList.contains("hidden") && !sidebar.contains(event.target)) {
            document.body.style.overflowY = "auto";
            return sidebar.classList.add("hidden");
        }
    })

})
