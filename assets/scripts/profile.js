
document.addEventListener("DOMContentLoaded", () => {
    
    const sections = document.querySelectorAll(".content-section .tab-section .tab-body");
    const togglers = document.querySelectorAll(".content-section .tab-buttons button");
    const button = document.querySelector("#image-upload div button");
    const status = document.querySelector("#image-upload div span");
    const upload = document.querySelector("#image-upload input");
    const form = document.querySelector("#image-upload");
    const user = document.querySelector("#user");

    togglers.forEach(toggler => {

        toggler.addEventListener("click", () => {
            const tab = document.getElementById(toggler.getAttribute("tab-name"));
            if (!tab) return;
            sections.forEach(section => !section.classList.contains("hidden") && section.classList.add("hidden"))
            togglers.forEach(toggler => toggler.classList.contains("tab-active") && toggler.classList.remove("tab-active"));
            tab.classList.remove("hidden");
            toggler.classList.add("tab-active");
        })

    })

    button.addEventListener("click", () => {
        upload.click();
    })

    upload.addEventListener("change", async () => {
        if (!upload.files[0]) return;
        
        const request = await fetch("api/images.php", {
            credentials: "include",
            method: "POST",
            body: new FormData(form)
        })

    })

    user.addEventListener("submit", async (event) => {
        event.preventDefault();

        const request = await fetch("api/users.php", {
            credentials: "include",
            method: "PUT",
            body: new FormData(form)
        });

    })

})