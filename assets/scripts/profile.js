
document.addEventListener("DOMContentLoaded", () => {
    
    const togglers = document.querySelectorAll(".content-section .tab-buttons");
    const sections = document.querySelectorAll(".content-section .tab-section");
    const button = document.querySelector("#image-upload div button");
    const status = document.querySelector("#image-upload div span");
    const upload = document.querySelector("#image-upload input");
    const form = document.querySelector("#image-upload");



    button.addEventListener("click", () => {
        upload.click();
    })

    upload.addEventListener("change", async () => {
        if (!upload.files[0]) return;
        
        const request = await fetch("api/images.php", {
            credentials: "include",
            method: "POST",
            body: new FormData(form)
        });

        //const response = await request.json();
        
        //status.classList.remove("hidden");
        //status.textContent = response.text;

    })

})