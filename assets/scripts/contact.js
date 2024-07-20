
document.addEventListener("DOMContentLoaded", () => {
    const contact = document.getElementById("contact-form");
    const modal = document.getElementById("modal");
    const status = modal.querySelector("#status");
    const button = modal.querySelector("#button");

    contact.addEventListener("submit", async (event) => {
        event.preventDefault();

        const request = await fetch("http://localhost/URUCODE/api/contact.php", {
            method: "POST",
        });

        const response = await request.json();

        status.textContent = response.text;
        modal.style.display = "flex";

        button.addEventListener("click", () => {
            modal.style.display = "none";
        })
        
    })

})