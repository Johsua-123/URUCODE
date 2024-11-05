
<?php
    
    session_start();
    $location = "tienda";
    
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-DF773N72G0"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'G-DF773N72G0');
        </script>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="public/icons/logo.png" type="image/x-icon">
        <link rel="stylesheet" href="assets/styles/module.css">
        <link rel="stylesheet" href="assets/styles/navbar.css">
        <link rel="stylesheet" href="assets/styles/footer.css">
        <link rel="stylesheet" href="assets/styles/tienda.css">
        <script src="assets/scripts/navbar.js"></script>
        <script src="assets/scripts/store.js"></script>
        <title>Tienda | Errea</title>
    </head>
    <body>
        <?php include "reusables/navbar.php" ?>
        <main>
            <div class="sidebar">
                <h2>Todas las Categorías</h2>
                <ul class="category-list">
                    <li><a href="#" data-category="ofertas">OFERTAS</a></li>
                    <li><a href="#" data-category="pc">PC</a></li>
                    <li><a id="notebook" href="#" data-category="notebooks">NOTEBOOKS</a></li>
                    <li><a href="#" data-category="consolas">CONSOLAS</a></li>
                    <li><a href="#" data-category="monitores">MONTORES</a></li>
                    <li><a href="#" data-category="tv">TV</a></li>
                    <li><a href="#" data-category="smartwatch">SMARTWATCH</a></li>
                    <li><a href="#" data-category="domotica">DOMOTICA</a></li>
                    <li><a href="#" data-category="componentes">COMPONENTES DE PC</a></li>
                    <li><a href="#" data-category="streaming">STREAMING</a></li>
                    <li><a href="#" data-category="perifericos">PERIFERICOS</a></li>
                    <li><a href="#" data-category="simuladores">SIMULADORES Y ACCESORIOS</a></li>
                    <li><a href="#" data-category="cables">CABLES Y ADAPTADORES</a></li>
                    <li><a href="#" data-category="otros">OTROS</a></li>
                </ul>
            </div>
            <div class="filter-bar">
                <label for="ordenar">Ordenar por:</label>
                <select id="ordenar">
                    <option value="popularidad">Popularidad</option>
                    <option value="precioBajoAlto">Precio: Bajo a Alto</option>
                    <option value="precioAltoBajo">Precio: Alto a Bajo</option>
                </select>
            </div>
            <div class="main-products">
                <div class="product-items">
                </div>
            </div>
        </main>
        <?php include "reusables/footer.php" ?>
    </body>
</html>