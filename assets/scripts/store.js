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
            
            const productoDiv = document.createElement('div');
            productoDiv.classList.add('product-card');

            const cardHeader = document.createElement('div');
            cardHeader.classList.add('card-header');
            const img = document.createElement('img');
            img.src = `http://localhost/URUCODE/public/images/${producto.nombre_imagen}` ? producto.nombre_imagen : ''; 
            img.alt = producto.nombre;
            cardHeader.appendChild(img);

            const cardItems = document.createElement('div');
            cardItems.classList.add('card-items');
            const nombre = document.createElement('h3');
            nombre.textContent = producto.nombre;
            const precio = document.createElement('p');
            precio.textContent = `US$${producto.precio_venta}`;
            cardItems.appendChild(nombre);
            cardItems.appendChild(precio);

const cardFooter = document.createElement('div');
cardFooter.classList.add('card-footer');
const detalleBtn = document.createElement('a');
detalleBtn.href = `product-visualizer.php?codigo=${producto.codigo}`; // Asegúrate de usar 'codigo'
detalleBtn.textContent = "Ver Detalle";
cardFooter.appendChild(detalleBtn);

            productoDiv.appendChild(cardHeader);
            productoDiv.appendChild(cardItems);
            productoDiv.appendChild(cardFooter);

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
