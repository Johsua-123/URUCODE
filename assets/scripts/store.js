document.addEventListener("DOMContentLoaded", function() {
    const categoryLinks = document.querySelectorAll(".category-list a");
    categoryLinks.forEach(link => {
        link.addEventListener("click", function(event) {
            event.preventDefault();
            const category = this.getAttribute("data-category");
            loadProductsByCategory(category);
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    cargarProductos(1);

    function cargarProductos(pagina) {
        fetch(`api/tienda.php?pagina=${pagina}`)
            .then(response => response.json())
            .then(data => {
                console.log("Datos recibidos:", data); 
                if (data.error) {
                    console.error("Error:", data.error);
                } else {
                    mostrarProductos(data.productos);
                    crearPaginacion(data.total_paginas, pagina);
                }
            })
            .catch(error => console.error("Error en la solicitud:", error));
    }

    function mostrarProductos(productos) {
        const contenedor = document.querySelector('.product-items');
        contenedor.innerHTML = '';
        productos.forEach(producto => {
            console.log("Producto:", producto); 
            
            // Creación de los elementos con las clases correctas
            const productoDiv = document.createElement('div');
            productoDiv.classList.add('product-card'); // Usamos la clase `product-card`

            // Sección de imagen
            const cardHeader = document.createElement('div');
            cardHeader.classList.add('card-header');
            const img = document.createElement('img');
            img.src = producto.nombre_imagen ? producto.nombre_imagen : 'ruta/por/defecto.jpg'; // Cambia 'ruta/por/defecto.jpg' si quieres una imagen por defecto
            img.alt = producto.nombre;
            cardHeader.appendChild(img);

            // Sección de nombre y precio
            const cardItems = document.createElement('div');
            cardItems.classList.add('card-items');
            const nombre = document.createElement('h3');
            nombre.textContent = producto.nombre;
            const precio = document.createElement('p');
            precio.textContent = `US$${producto.precio_venta}`;
            cardItems.appendChild(nombre);
            cardItems.appendChild(precio);

            // Botón de "Ver Detalle"
            const cardFooter = document.createElement('div');
            cardFooter.classList.add('card-footer');
            const detalleBtn = document.createElement('a');
            detalleBtn.href = "#"; // Cambia a la URL del producto si es necesario
            detalleBtn.textContent = "Ver Detalle";
            cardFooter.appendChild(detalleBtn);

            // Ensamblar los elementos en la tarjeta principal
            productoDiv.appendChild(cardHeader);
            productoDiv.appendChild(cardItems);
            productoDiv.appendChild(cardFooter);

            // Añadir la tarjeta de producto al contenedor
            contenedor.appendChild(productoDiv);
        });
    }

    function crearPaginacion(totalPaginas, paginaActual) {
        const paginacion = document.querySelector('.pagination');
        paginacion.innerHTML = '';
        for (let i = 1; i <= totalPaginas; i++) {
            const boton = document.createElement('button');
            boton.textContent = i;
            if (i === paginaActual) {
                boton.classList.add('active');
            }
            boton.addEventListener('click', () => cargarProductos(i));
            paginacion.appendChild(boton);
        }
    }
});
