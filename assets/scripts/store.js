        //filtro de plata
        function actualizarMin() {
            const minValue = document.getElementById("rangoPrecioMin").value;
            document.getElementById("precioMin").innerText = minValue;
            filtrarProductos();
        }

        function actualizarMax() {
            const maxValue = document.getElementById("rangoPrecioMax").value;
            document.getElementById("precioMax").innerText = maxValue;
            filtrarProductos();
        } 

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
        
        // CARGA DE PRODUCTOS

        function loadProductsByCategory(category) {
            
            const products = getProductsForCategory(category);
            
            const productItemsContainer = document.querySelector(".product-items");
            productItemsContainer.innerHTML = ""; // Limpiar los productos actuales antes de cargar los otros
        
            products.forEach(product => {
                const productCard = document.createElement("div");
                productCard.classList.add("product-card");
                productCard.innerHTML = `
                    <div class="card-header">
                        <img src="${product.image}" alt="${product.name}">
                    </div>
                    <div class="card-items">
                        <h1>${product.name}</h1>
                        <h2>${product.price}</h2>
                    </div>
                    <div class="card-footer">
                        <a href="">Ver detalles</a>
                    </div>
                `;
                productItemsContainer.appendChild(productCard);
            });
        }
        
        function getProductsForCategory(category) {
    
            const productsData = {
                ofertas: [
                    {name: "Producto Oferta 1", price: "U$S 80", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+1"},
                    {name: "Producto Oferta 2", price: "U$S 99", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+2"},
                    {name: "Producto Oferta 3", price: "U$S 110", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+1"},
                    {name: "Producto Oferta 4", price: "U$S 135", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+1"},
                    {name: "Producto Oferta 5", price: "U$S 250", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+2"},
                    {name: "Producto Oferta 6", price: "U$S 255", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+2"},
                    {name: "Producto Oferta 7", price: "U$S 299", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+2"},
                    {name: "Producto Oferta 8", price: "U$S 399", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+2"},
                    {name: "Producto Oferta 9", price: "U$S 405", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+1"},
                    {name: "Producto Oferta 10", price: "U$S 420", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+2"},
                    {name: "Producto Oferta 11", price: "U$S 420", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+1"},
                    {name: "Producto Oferta 12", price: "U$S 469", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+1"},
                    {name: "Producto Oferta 12", price: "U$S 480", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+2"},
                    {name: "Producto Oferta 13", price: "U$S 510", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+2"},
                    {name: "Producto Oferta 14", price: "U$S 600", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+2"},
                    {name: "Producto Oferta 15", price: "U$S 899", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+2"},
                ],

                pc: [
                    {name: "PC Gamer", price: "U$S 1499", image: "https://via.placeholder.com/100x100?text=Imagen+PC+1"},
                    {name: "PC Oficina", price: "U$S 599", image: "https://via.placeholder.com/100x100?text=Imagen+PC+2"},
                    {name: "PC Gamer", price: "U$S 1499", image: "https://via.placeholder.com/100x100?text=Imagen+PC+1"},
                    {name: "PC Oficina", price: "U$S 599", image: "https://via.placeholder.com/100x100?text=Imagen+PC+2"},
                    {name: "PC Gamer", price: "U$S 1499", image: "https://via.placeholder.com/100x100?text=Imagen+PC+1"},
                    {name: "PC Oficina", price: "U$S 599", image: "https://via.placeholder.com/100x100?text=Imagen+PC+2"},
                    {name: "PC Gamer", price: "U$S 1499", image: "https://via.placeholder.com/100x100?text=Imagen+PC+1"},
                    {name: "PC Oficina", price: "U$S 599", image: "https://via.placeholder.com/100x100?text=Imagen+PC+2"},
                ],
                
                notebooks: [
                    {name: "Notebook Lenovo", price: "U$S 1299", image: "https://via.placeholder.com/100x100?text=Imagen+Notebook+1"},
                    {name: "Notebook HP", price: "U$S 1399", image: "https://via.placeholder.com/100x100?text=Imagen+Notebook+2"},
                    {name: "Notebook Lenovo", price: "U$S 1299", image: "https://via.placeholder.com/100x100?text=Imagen+Notebook+1"},
                    {name: "Notebook HP", price: "U$S 1399", image: "https://via.placeholder.com/100x100?text=Imagen+Notebook+2"},                 
                    {name: "Notebook HP", price: "U$S 1399", image: "https://via.placeholder.com/100x100?text=Imagen+Notebook+2"},                    
                ],                                

                consolas: [
                    {name: "Producto consola 1", price: "U$S 80", image: "https://via.placeholder.com/100x100?text=Imagen+consola+1"},
                    {name: "Producto consola 2", price: "U$S 99", image: "https://via.placeholder.com/100x100?text=Imagen+consola+2"},
                    {name: "Producto consola 3", price: "U$S 110", image: "https://via.placeholder.com/100x100?text=Imagen+consola+1"},
                    {name: "Producto consola 4", price: "U$S 135", image: "https://via.placeholder.com/100x100?text=Imagen+consola+1"},
                    {name: "Producto consola 5", price: "U$S 250", image: "https://via.placeholder.com/100x100?text=Imagen+consola+2"},
                    {name: "Producto consola 6", price: "U$S 285", image: "https://via.placeholder.com/100x100?text=Imagen+consola+1"},
                    {name: "Producto consola 7", price: "U$S 300", image: "https://via.placeholder.com/100x100?text=Imagen+consola+2"},
                    {name: "Producto consola 8", price: "U$S 580", image: "https://via.placeholder.com/100x100?text=Imagen+consola+1"},
                ],                                

                monitores: [
                    {name: "Producto monitor 1", price: "U$S 80", image: "https://via.placeholder.com/100x100?text=Imagen+monitor+1"},
                    {name: "Producto monitor 2", price: "U$S 99", image: "https://via.placeholder.com/100x100?text=Imagen+monitor+2"},
                    {name: "Producto monitor 3", price: "U$S 110", image: "https://via.placeholder.com/100x100?text=Imagen+monitor+1"},
                    {name: "Producto monitor 4", price: "U$S 135", image: "https://via.placeholder.com/100x100?text=Imagen+monitor+1"},
                    {name: "Producto monitor 5", price: "U$S 250", image: "https://via.placeholder.com/100x100?text=Imagen+monitor+2"},
                    {name: "Producto monitor 6", price: "U$S 285", image: "https://via.placeholder.com/100x100?text=Imagen+monitor+1"},
                    {name: "Producto monitor 7", price: "U$S 300", image: "https://via.placeholder.com/100x100?text=Imagen+monitor+2"},
                    {name: "Producto monitor 8", price: "U$S 580", image: "https://via.placeholder.com/100x100?text=Imagen+monitor+1"},
                ],
                
                tv: [
                    {name: "Producto tv 1", price: "U$S 80", image: "https://via.placeholder.com/100x100?text=Imagen+Tv+1"},
                    {name: "Producto tv 2", price: "U$S 99", image: "https://via.placeholder.com/100x100?text=Imagen+Tv+2"},
                    {name: "Producto tv 3", price: "U$S 110", image: "https://via.placeholder.com/100x100?text=Imagen+Tv+1"},
                    {name: "Producto tv 4", price: "U$S 135", image: "https://via.placeholder.com/100x100?text=Imagen+Tv+1"},
                    {name: "Producto tv 5", price: "U$S 250", image: "https://via.placeholder.com/100x100?text=Imagen+Tv+2"},
                    {name: "Producto tv 6", price: "U$S 285", image: "https://via.placeholder.com/100x100?text=Imagen+Tv+1"},
                    {name: "Producto tv 7", price: "U$S 300", image: "https://via.placeholder.com/100x100?text=Imagen+Tv+2"},
                    {name: "Producto tv 8", price: "U$S 580", image: "https://via.placeholder.com/100x100?text=Imagen+Tv+1"},
                ],

                smartwatch: [
                    {name: "Producto Oferta 1", price: "U$S 80", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+1"},
                    {name: "Producto Oferta 2", price: "U$S 99", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+2"},
                    {name: "Producto Oferta 3", price: "U$S 110", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+1"},
                    {name: "Producto Oferta 4", price: "U$S 135", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+1"},
                    {name: "Producto Oferta 5", price: "U$S 250", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+2"},
                    {name: "Producto Oferta 6", price: "U$S 285", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+1"},
                    {name: "Producto Oferta 7", price: "U$S 300", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+2"},
                    {name: "Producto Oferta 8", price: "U$S 580", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+1"},
                ],
                
                domotica: [
                    {name: "Producto Oferta 1", price: "U$S 80", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+1"},
                    {name: "Producto Oferta 2", price: "U$S 99", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+2"},
                    {name: "Producto Oferta 3", price: "U$S 110", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+1"},
                    {name: "Producto Oferta 4", price: "U$S 135", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+1"},
                    {name: "Producto Oferta 5", price: "U$S 250", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+2"},
                    {name: "Producto Oferta 6", price: "U$S 285", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+1"},
                    {name: "Producto Oferta 7", price: "U$S 300", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+2"},
                    {name: "Producto Oferta 8", price: "U$S 580", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+1"},
                ],
                
                componentes: [
                    {name: "Producto Oferta 1", price: "U$S 80", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+1"},
                    {name: "Producto Oferta 2", price: "U$S 99", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+2"},
                    {name: "Producto Oferta 3", price: "U$S 110", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+1"},
                    {name: "Producto Oferta 4", price: "U$S 135", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+1"},
                    {name: "Producto Oferta 5", price: "U$S 250", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+2"},
                    {name: "Producto Oferta 6", price: "U$S 285", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+1"},
                    {name: "Producto Oferta 7", price: "U$S 300", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+2"},
                    {name: "Producto Oferta 8", price: "U$S 580", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+1"},
                ],
                                
                streaming: [
                    {name: "Producto Oferta 1", price: "U$S 80", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+1"},
                    {name: "Producto Oferta 2", price: "U$S 99", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+2"},
                    {name: "Producto Oferta 3", price: "U$S 110", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+1"},
                    {name: "Producto Oferta 4", price: "U$S 135", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+1"},
                    {name: "Producto Oferta 5", price: "U$S 250", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+2"},
                    {name: "Producto Oferta 6", price: "U$S 285", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+1"},
                    {name: "Producto Oferta 7", price: "U$S 300", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+2"},
                    {name: "Producto Oferta 8", price: "U$S 580", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+1"},
                ],
                                
                perifericos: [
                    {name: "Producto Oferta 1", price: "U$S 80", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+1"},
                    {name: "Producto Oferta 2", price: "U$S 99", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+2"},
                    {name: "Producto Oferta 3", price: "U$S 110", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+1"},
                    {name: "Producto Oferta 4", price: "U$S 135", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+1"},
                    {name: "Producto Oferta 5", price: "U$S 250", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+2"},
                    {name: "Producto Oferta 6", price: "U$S 285", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+1"},
                    {name: "Producto Oferta 7", price: "U$S 300", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+2"},
                    {name: "Producto Oferta 8", price: "U$S 580", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+1"},
                ],
                                
                simuladores: [
                    {name: "Producto Oferta 1", price: "U$S 80", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+1"},
                    {name: "Producto Oferta 2", price: "U$S 99", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+2"},
                    {name: "Producto Oferta 3", price: "U$S 110", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+1"},
                    {name: "Producto Oferta 4", price: "U$S 135", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+1"},
                    {name: "Producto Oferta 5", price: "U$S 250", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+2"},
                    {name: "Producto Oferta 6", price: "U$S 285", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+1"},
                    {name: "Producto Oferta 7", price: "U$S 300", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+2"},
                    {name: "Producto Oferta 8", price: "U$S 580", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+1"},
                ],
                                
                cables: [
                    {name: "Producto Oferta 1", price: "U$S 80", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+1"},
                    {name: "Producto Oferta 2", price: "U$S 99", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+2"},
                    {name: "Producto Oferta 3", price: "U$S 110", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+1"},
                    {name: "Producto Oferta 4", price: "U$S 135", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+1"},
                    {name: "Producto Oferta 5", price: "U$S 250", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+2"},
                    {name: "Producto Oferta 6", price: "U$S 285", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+1"},
                    {name: "Producto Oferta 7", price: "U$S 300", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+2"},
                    {name: "Producto Oferta 8", price: "U$S 580", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+1"},
                ],
                                
                otros: [
                    {name: "Producto Oferta 1", price: "U$S 80", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+1"},
                    {name: "Producto Oferta 2", price: "U$S 99", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+2"},
                    {name: "Producto Oferta 3", price: "U$S 110", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+1"},
                    {name: "Producto Oferta 4", price: "U$S 135", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+1"},
                    {name: "Producto Oferta 5", price: "U$S 250", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+2"},
                    {name: "Producto Oferta 6", price: "U$S 285", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+1"},
                    {name: "Producto Oferta 7", price: "U$S 300", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+2"},
                    {name: "Producto Oferta 8", price: "U$S 580", image: "https://via.placeholder.com/100x100?text=Imagen+Oferta+1"},
                ],
            };
        
            return productsData[category] || [];
        }

        document.addEventListener("DOMContentLoaded", function() {
            const categoryLinks = document.querySelectorAll(".category-list a");
            categoryLinks.forEach(link => {
                link.addEventListener("click", function(event) {
                    event.preventDefault();
                    const category = this.getAttribute("data-category");
                    loadProductsByCategory(category);
                });
            });
        
            // Cargar una categoría por defecto al inicio
            loadProductsByCategory("ofertas");
        });