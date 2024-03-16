
document.addEventListener("DOMContentLoaded", () => {
    const query = document.getElementById("search-query");
    const button = document.getElementById("search-button");

    button.addEventListener("click", () => {
        if (!query.value) return;
        query.textContent = "";
    })

    
});