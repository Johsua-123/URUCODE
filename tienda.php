<?php 
session_start();
$location = "tienda";
require 'api/mysql.php';

$result = $mysql->query("SELECT * FROM categorias");

$productos_result = [];
$orden = isset($_GET['orden']) ? $_GET['orden'] : null;
$search_query = "";


$order_by = "productos.precio_venta ASC"; 
if ($orden === "precioAltoBajo") {
    $order_by = "productos.precio_venta DESC";
}

// Filtro 
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $busqueda = $mysql->real_escape_string($_GET['search']);
    $search_query = "AND (productos.nombre LIKE '%$busqueda%' 
                      OR productos.marca LIKE '%$busqueda%' 
                      OR productos.modelo LIKE '%$busqueda%' 
                      OR productos.descripcion LIKE '%$busqueda%')";
}

// consulta
$productos_result = $mysql->query("
    SELECT productos.*, CONCAT(imagenes.nombre, '-', imagenes.codigo, imagenes.extension) AS imagen
    FROM productos 
    LEFT JOIN imagenes ON productos.imagen_id = imagenes.codigo
    WHERE productos.en_venta = 1 $search_query
    ORDER BY $order_by
");
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
    <link rel="shortcut icon" href="public/icons/errea.png" type="image/x-icon">
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
            <form method="GET" action="tienda.php">
                <label for="ordenar">Ordenar por:</label>
                <select id="ordenar" name="orden" onchange="this.form.submit()">
                    <option value="precioBajoAlto" <?php echo $orden === 'precioBajoAlto' ? 'selected' : ''; ?>>Precio: Bajo a Alto</option>
                    <option value="precioAltoBajo" <?php echo $orden === 'precioAltoBajo' ? 'selected' : ''; ?>>Precio: Alto a Bajo</option>
                </select>
                <?php if (isset($_GET['search'])) { ?>
                    <input type="hidden" name="search" value="<?php echo htmlspecialchars($_GET['search']); ?>">
                <?php } ?>
            </form>
        </div>

        <div class="main-products">
            <div class="product-items">
                <?php while ($producto = $productos_result->fetch_assoc()) {
                    $imagen_url = $producto['imagen'] ? 'public/images/' . htmlspecialchars($producto['imagen']) : 'https://via.placeholder.com/150';
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
            </div>
        </div>
    </main>
    <?php include "reusables/footer.php" ?>
</body>
</html>

<?php $mysql->close(); ?>
