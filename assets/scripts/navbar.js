
document.addEventListener("DOMContentLoaded", () => {

   
    const navbar = document.getElementById("navbar");
    const sidebar = document.getElementById("sidebar");
    const dropdowns = document.querySelectorAll(".dropdown");

    navbar.addEventListener("click", (event) => {
        document.body.style.overflowY = "hidden";
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
        if (sidebar.style.display == "flex" && !sidebar.contains(event.target)) {
            document.body.style.overflowY = "auto";
            return sidebar.style.display = "none";
        }
    })

})
