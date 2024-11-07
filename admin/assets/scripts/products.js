// Función para mostrar el modal y cargar las categorías
function toggleModal() {
    const modal = document.getElementById("productModal");
    modal.classList.toggle("hidden");

    if (!modal.classList.contains("hidden")) {
        cargarCategorias();
    }
}

// Función para cargar las categorías desde categorias.php
function cargarCategorias() {
    fetch('categorias.php')
        .then(response => response.json())
        .then(categorias => {
            const container = document.getElementById('categorias-container');
            container.innerHTML = ''; // Limpiar contenedor antes de agregar categorías

            categorias.forEach(categoria => {
                // Crear checkbox para cada categoría
                const checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.name = 'categorias[]'; // Nombre para manejar como array en PHP
                checkbox.value = categoria.id;

                const label = document.createElement('label');
                label.textContent = categoria.nombre;

                container.appendChild(checkbox);
                container.appendChild(label);
                container.appendChild(document.createElement('br')); // Salto de línea
            });
        })
        .catch(error => console.error("Error al cargar las categorías:", error));
}
