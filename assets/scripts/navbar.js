
document.addEventListener("DOMContentLoaded", () => {

    // barra lateral en pantalla moviles
    const navbar = document.getElementById("navbar");
    const sidebar = document.getElementById("sidebar");

    // seccion de dropdowns
    const dropdowns = document.querySelectorAll(".dropdown");

    navbar.addEventListener("click", (event) => {
        sidebar.style.display = "flex";
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
        if (sidebar.style.display == "flex") {
            return sidebar.style.display = "none";
        }
        dropdowns.forEach(dropdown => {
            const menu = dropdown.querySelector(".dropdown-menu");
            if (dropdown.classList.contains("hidden") || menu.contains(event.target)) return;
            return menu.classList.add("hidden")
        })
    })

})
