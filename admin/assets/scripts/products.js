// cambia la visibilidad del modal
function toggleModal() {
    const modal = document.getElementById("productModal");
    modal.classList.toggle("hidden");

    // Si el modal esta visible carga las cat
    if (!modal.classList.contains("hidden")) {
        cargarCategorias();
    }
}

// Carga las categorías desde el servidor y las muestra en el modal
function cargarCategorias() {
    fetch("categorias.php") 
        .then(response => response.json()) // Convierte a JSON
        .then(categorias => {
            const container = document.getElementById("categorias-container");
            container.innerHTML = ""; // Limpia contenido 

            // Agrega un checkbox para cada categoría
            categorias.forEach(categoria => {
                container.innerHTML += `
                    <input type="checkbox" name="categorias[]" value="${categoria.id}">
                    <label>${categoria.nombre}</label><br>
                `;
            });
        })
        .catch(error => console.error("Error al cargar las categoria", error));
}
