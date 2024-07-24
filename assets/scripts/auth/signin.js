
document.addEventListener("DOMContentLoaded", () => {
    const signin = document.getElementById("signin");
    const modal = document.getElementById("signin-modal");
    const status = document.querySelector("#status");
    const button = document.querySelector("#button");

    const location = window.location;
    const basePath = location.href.substring(0, location.href.lastIndexOf('/') + 1);
    const redirect = modal.dataset.redirect;

    signin.addEventListener("submit", async (event) => {
        event.preventDefault();
    
        const request = await fetch("http://localhost/URUCODE/api/signin.php", {
            method: "POST",
            body: new FormData(signin)
        })

        const response = await request.json();

        status.textContent = response.text;
        modal.style.display = "flex";

        button.addEventListener("click", () => {
            if (response.code && response.code == 200) return window.location.href = `${basePath}${redirect}`;
            modal.style.display = "none";
        })

    })
    
})