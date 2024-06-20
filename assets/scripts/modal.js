
document.addEventListener("DOMContentLoaded", () => {
    const params = new URLSearchParams(window.location.search);
    if (!params.get("status")) return;

    const modal = document.querySelector("#modal");
    const status = modal.querySelector("#status");
    const button = modal.querySelector("#button");

    status.textContent = params.get("status");
    modal.style.display = "flex";

    const location = window.location;
    const basePath = location.href.substring(0, location.href.lastIndexOf('/') + 1);
    const redirect = modal.dataset.redirect;

    button.addEventListener("click", () => {
        //if (params.get("status-code") == "200") return window.location.href = `${basePath}${redirect}`;
        modal.style.display = "none";
    })

});