<?php 
session_start();
$location = "tienda";

define("URUCODE", true);
require 'api/mysql.php';

$servername = "localhost";$username = "duenio";$password = "duenio";$dbname = "urucode";

$mysql = new mysqli($servername, $username, $password, $dbname);
if ($mysql->connect_error) {
    die("Error de conexión a la base de datos: " . $mysql->connect_error);
}

$result = $mysql->query("SELECT * FROM categorias");
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
                <?php while ($categoria = $result->fetch_assoc()) { ?>
                    <li><a href="#" data-category="<?php echo htmlspecialchars($categoria['nombre']); ?>"><?php echo htmlspecialchars($categoria['nombre']); ?></a></li>
                <?php } ?>
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
            <div class="pagination">
            </div>
        </div>
    </main>
    <?php include "reusables/footer.php" ?>
</body>
</html>

<?php $mysql->close(); ?>
