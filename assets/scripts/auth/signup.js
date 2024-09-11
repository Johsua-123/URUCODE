
document.addEventListener("DOMContentLoaded", () => {
    const signup = document.getElementById("signup");
    const modal = document.getElementById("signup-modal");
    const status = document.querySelector("#status");
    const button = document.querySelector("#button");

    const location = window.location;
    const redirect = modal.getAttribute("redirect");
    const basePath = location.href.substring(0, location.href.lastIndexOf('/') + 1);

    signup.addEventListener("submit", async (event) => {
        event.preventDefault();
    
        const request = await fetch("api/signup.php", {
            method: "POST",
            body: new FormData(signup)
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