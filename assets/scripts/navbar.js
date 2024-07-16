
document.addEventListener("DOMContentLoaded", () => {
    const search = document.getElementById("search");
    const navOpen = document.getElementById("nav-open");
    const navClose = document.getElementById("nav-close");

    let mobileNav = false;

    search.addEventListener("submit", (event) => {
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

})