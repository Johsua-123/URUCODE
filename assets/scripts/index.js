
document.addEventListener("DOMContentLoaded", async () => {

    //const products = document.getElementById("");

    const category = new FormData();
    category.append("name", "prueba");

    const request = await fetch("api/categories.php", {
        method: "GET"
    });

    const response = await request.text();
    console.table(response);

})