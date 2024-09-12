
document.addEventListener("DOMContentLoaded", () => {
    const signin = document.getElementById("signin");
    const modal = document.getElementById("signin-modal");
    const status = document.querySelector("#status");
    const button = document.querySelector("#button");

    const location = window.location;
    const redirect = modal.getAttribute("redirect");
    const basePath = location.href.substring(0, location.href.lastIndexOf('/') + 1);

    signin.addEventListener("submit", async (event) => {
        event.preventDefault();
    
        const request = await fetch("api/signin.php", {
            method: "POST",
            body: new FormData(signin)
        })

        console.log(await request.text())

        /*
        const response = await request.json();

        status.textContent = response.text;
        modal.style.display = "flex";

        console.table(response)

        button.addEventListener("click", () => {
            if (response.code && response.code == 200) return window.location.href = `${basePath}${redirect}`;
            modal.style.display = "none";
        })
        */
       
    })
    
    
})