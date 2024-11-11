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
                    productoDiv.classList.add('product');
                    productoDiv.innerHTML = `
                        <img src="public/images/${producto.imagen}" alt="${producto.nombre}">
                        <h3>${producto.nombre}</h3>
                        <p>${producto.descripcion}</p>
                        <p>Precio: $${producto.precio}</p>
                    `;
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
        
