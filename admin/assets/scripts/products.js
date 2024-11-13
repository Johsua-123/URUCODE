
function toggleModal() {
    const modal = document.getElementById("productModal");
    modal.classList.toggle("hidden");

    if (!modal.classList.contains("hidden")) {
        cargarCategorias();
    }
}

// carga las categorías desde categorias.php
function cargarCategorias() {
    fetch('categorias.php')
        .then(response => response.json())
        .then(categorias => {
            const container = document.getElementById('categorias-container');
            container.innerHTML = '';

            categorias.forEach(categoria => {
                // Crear checkbox categoría
                const checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.name = 'categorias[]';
                checkbox.value = categoria.id;

                const label = document.createElement('label');
                label.textContent = categoria.nombre;

                container.appendChild(checkbox);
                container.appendChild(label);
                container.appendChild(document.createElement('br'));
            });
        })
        .catch(error => console.error("Error al cargar las categorías:", error));
}
