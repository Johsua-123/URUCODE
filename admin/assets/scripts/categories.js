function toggleModal() {
    const modal = document.getElementById("categoryModal");
    modal.classList.toggle("hidden");
}

// Cargar productos de una categoría
document.querySelectorAll('.category-link').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        const categoryId = this.getAttribute('data-category-id');
        loadProducts(categoryId);
    });
});

// Función para cargar productos por categoría usando AJAX
function loadProducts(categoryId) {
    const productItems = document.getElementById('productItems');
    productItems.innerHTML = 'Cargando...';

    fetch(`api/get_products.php?categoria=${categoryId}`)
        .then(response => response.json())
        .then(data => {
            productItems.innerHTML = '';
            if (data.length > 0) {
                data.forEach(product => {
                    const productDiv = document.createElement('div');
                    productDiv.classList.add('product-item');
                    productDiv.innerHTML = `
                        <img src="${product.imagen}" alt="${product.nombre}">
                        <h3>${product.nombre}</h3>
                        <p>Precio: $${product.precio}</p>
                        <p>${product.descripcion}</p>
                    `;
                    productItems.appendChild(productDiv);
                });
            } else {
                productItems.innerHTML = '<p>No hay productos en esta categoría.</p>';
            }
        })
        .catch(error => {
            productItems.innerHTML = '<p>Error al cargar productos.</p>';
            console.error('Error:', error);
        });
}
