function toggleModal() {
    const modal = document.getElementById("productModal");
    modal.classList.toggle("hidden");
    if (!modal.classList.contains("hidden")) {
        cargarCategorias();
    }
}

function cargarCategorias() {
    fetch('categorias.php')
        .then(response => response.json())
        .then(categorias => {
            const container = document.getElementById('categorias-container');
            container.innerHTML = '';

            categorias.forEach(categoria => {
                container.innerHTML += `
                    <input type="checkbox" name="categorias[]" value="${categoria.id}">
                    <label>${categoria.nombre}</label><br>
                `;
            });
        })
        .catch(error => console.error("Error al cargar las categorías:", error));
}
