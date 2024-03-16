
document.addEventListener("DOMContentLoaded", () => {

    const open = document.getElementById("hamburguer-open");
    const close = document.getElementById("hamburguer-close");

    open.addEventListener("click", () => {
        open.classList.add("hide");
        close.classList.remove("hide");
    });

    close.addEventListener("click", () => {
        close.classList.add("hide");
        open.classList.remove("hide");
    });

})