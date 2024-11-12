<?php 
session_start();
$location = "tienda";

define("URUCODE", true);
require 'api/mysql.php';

$servername = "localhost";
$username = "duenio";
$password = "duenio";
$dbname = "urucode";

$mysql = new mysqli($servername, $username, $password, $dbname);
if ($mysql->connect_error) {
    die("Error de conexión a la base de datos: " . $mysql->connect_error);
}

$result = $mysql->query("SELECT * FROM categorias");

// productos y sus imágenes
$productos_result = $mysql->query("SELECT productos.*, imagenes.enlace AS imagen_enlace 
                                   FROM productos 
                                   LEFT JOIN imagenes ON productos.imagen_id = imagenes.codigo");
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
    <title>Tienda | Errea</title>
</head>
<body>
<?php include "reusables/navbar.php"; ?>
    <main>
        <div class="sidebar">
            <h2>Todas las Categorías</h2>
            <ul class="category-list-shop">
                <?php while ($categoria = $result->fetch_assoc()) { ?>
                    <li><a href="#" data-category="<?php echo htmlspecialchars($categoria['nombre']); ?>"><?php echo htmlspecialchars($categoria['nombre']); ?></a></li>
                <?php } ?>
            </ul>
        </div>

        <div class="filter-bar">
            <label for="ordenar">Ordenar por:</label>
            <select id="ordenar">
                <option value="precioBajoAlto" <?php echo isset($orden) && $orden === 'precioBajoAlto' ? 'selected' : ''; ?>>Precio: Bajo a Alto</option>
                <option value="precioAltoBajo" <?php echo isset($orden) && $orden === 'precioAltoBajo' ? 'selected' : ''; ?>>Precio: Alto a Bajo</option>
            </select>
        </div>

        <div class="main-products">
            <div class="product-items">
                <?php while ($producto = $productos_result->fetch_assoc()) {
                    $imagen_url = $producto['imagen_enlace'] ? 'public/images/' . htmlspecialchars($producto['imagen_enlace']) : 'https://via.placeholder.com/150';
                    ?>
                    <div class="product-card">
                        <div class="product-image">
                            <img src="<?php echo $imagen_url; ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                        </div>
                        <div class="product-info">
                            <h3 class="product-name"><?php echo htmlspecialchars($producto['nombre']); ?></h3>
                            <p class="product-price">US$<?php echo htmlspecialchars($producto['precio_venta']); ?></p>
                        </div>
                        <div class="product-action">
                            <a href="product-visualizer.php?codigo=<?php echo htmlspecialchars($producto['codigo']); ?>" class="btn-view">Ver Detalle</a>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="pagination">
                <!-- Aquí podrías agregar botones de paginación -->
            </div>
        </div>
    </main>
    <?php include "reusables/footer.php" ?>
</body>
</html>

<?php $mysql->close(); ?>
