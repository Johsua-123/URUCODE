
document.addEventListener("DOMContentLoaded", () => {
    const signup = document.getElementById("signup");
    const modal = document.getElementById("signup-modal");
    const status = document.querySelector("#status");
    const button = document.querySelector("#button");

    const location = window.location;
    const basePath = location.href.substring(0, location.href.lastIndexOf('/') + 1);
    const redirect = modal.dataset.redirect;

    signup.addEventListener("submit", async (event) => {
        event.preventDefault();
    
        const request = await fetch("http://localhost/URUCODE/api/signup.php", {
            method: "POST",
            body: new FormData(signup)
        })

        /*console.log(await request.text());*/

        
        const response = await request.json();

        status.textContent = response.text;
        modal.style.display = "flex";

        button.addEventListener("click", () => {
            if (response.code && response.code == 200) return window.location.href = `${basePath}${redirect}`;
            modal.style.display = "none";
        })
        
    })
    
})