<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="public/icons/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/styles/module.css">
    <link rel="stylesheet" href="assets/styles/navbar.css">
    <link rel="stylesheet" href="assets/styles/footer.css">
    <link rel="stylesheet" href="assets/styles/storeV2.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            <a href="product-visualizer.php?code=1" class="ver-detalles">Ver Detalles</a>

                <li><a href="#" data-category="ofertas">OFERTAS</a></li>
                <li><a href="#" data-category="pc">PC</a></li>
                <li><a href="#" data-category="notebooks">NOTEBOOKS</a></li>
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
            <div class="filter">
                <a><b>PRECIO</b></a>
                <div class="money-filter">
                    <label for="rangoPrecioMin"><b>Precio Mínimo:</b> <span id="precioMin"><b>0</b></span></label>
                    <input type="range" id="rangoPrecioMin" min="0" max="5000" value="0" oninput="actualizarMin()">
                    <label for="rangoPrecioMax"><b>Precio Máximo:</b> <span id="precioMax"><b>0</b></span></label>
                    <input type="range" id="rangoPrecioMax" min="0" max="5000" value="100" oninput="actualizarMax()">
                </div>
            </div>
        </div>
        <div class="filter-bar">
            <label for="ordenar">Ordenar por:</label>
            <select id="ordenar" onchange="filtrarArticulos()">
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