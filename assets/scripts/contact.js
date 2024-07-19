
document.addEventListener("DOMContentLoaded", () => {
    const contact = document.getElementById("contact");
    const modal = document.getElementById("modal");
    const status = modal.querySelector("#status");
    const button = modal.querySelector("#button");

    contact.addEventListener("submit", async (event) => {
        event.preventDefault();

        status.textContent = "Funcionalidad aun no implementada";
        modal.style.display = "flex";

        button.addEventListener("click", () => {
            modal.style.display = "none";
        })
        
    })

})