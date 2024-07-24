
document.addEventListener("DOMContentLoaded", () => {
    const search = document.getElementById("search");
    const sidebar = document.getElementById("sidebar");
    const navOpen = document.getElementById("nav-open");
    const navClose = document.getElementById("nav-close");
    const profile = document.getElementById("nav-profile");
    const dropdown = document.getElementById("nav-dropdown");

    let mobileNav = false;

    search.addEventListener("submit", async (event) => {
        event.preventDefault();

    })

    navOpen.addEventListener("click", () => {
        mobileNav = true;
        navOpen.style.display = "none";
        navClose.style.display = "block";
    })

    navClose.addEventListener("click", () => {
        mobileNav = false;
        navClose.style.display = "none";
        navOpen.style.display = "block";
    })

    profile.addEventListener("click", () => {
        dropdown.style.display = (dropdown.style.display == "block" ? "none" : "flex")
    })

    document.addEventListener("click", (event) => {
        if (!dropdown.contains(event.target) && event.target !== profile) {
            dropdown.style.display = "none";
        }
    })

})