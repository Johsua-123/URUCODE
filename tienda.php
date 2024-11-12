<?php 
session_start();
$location = "tienda";

define("URUCODE", true);
require 'api/mysql.php';

// Función para obtener categorías
function obtenerCategorias($conexion) {
    $query = "SELECT * FROM categorias";
    return $conexion->query($query);
}

// Función para obtener productos
function obtenerProductos($conexion, $busqueda = null) {
    $query = "
        SELECT productos.*, imagenes.enlace AS imagen_enlace 
        FROM productos 
        LEFT JOIN imagenes ON productos.imagen_id = imagenes.codigo
        WHERE productos.en_venta = 1";

    if ($busqueda) {
        $query .= " AND (
            productos.nombre LIKE CONCAT('%', ?, '%') 
            OR productos.marca LIKE CONCAT('%', ?, '%') 
            OR productos.modelo LIKE CONCAT('%', ?, '%') 
            OR productos.descripcion LIKE CONCAT('%', ?, '%')
        )";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param('ssss', $busqueda, $busqueda, $busqueda, $busqueda);
        $stmt->execute();
        return $stmt->get_result();
    } else {
        return $conexion->query($query);
    }
}

$categorias = obtenerCategorias($mysql);

$productos_result = [];
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $busqueda = $mysql->real_escape_string($_GET['search']);
    $productos_result = $mysql->query("
        SELECT productos.*, imagenes.enlace AS imagen_enlace 
        FROM productos 
        LEFT JOIN imagenes ON productos.imagen_id = imagenes.codigo
        WHERE productos.en_venta = 1 AND (productos.nombre LIKE '%$busqueda%' 
        OR productos.marca LIKE '%$busqueda%' 
        OR productos.modelo LIKE '%$busqueda%' 
        OR productos.descripcion LIKE '%$busqueda%')
    ");
} else {
    $productos_result = $mysql->query("
        SELECT productos.*, imagenes.nombre AS imagen_enlace 
        FROM productos 
        LEFT JOIN imagenes ON productos.imagen_id = imagenes.codigo
        WHERE productos.en_venta = 1
    ");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-DF773N72G0"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
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
            <?php if ($categorias->num_rows > 0): ?>
                <?php while ($categoria = $categorias->fetch_assoc()): ?>
                    <li>
                        <a href="#" data-category="<?php echo htmlspecialchars($categoria['nombre']); ?>" aria-label="Filtrar por categoría <?php echo htmlspecialchars($categoria['nombre']); ?>">
                            <?php echo htmlspecialchars($categoria['nombre']); ?>
                        </a>
                    </li>
                <?php endwhile; ?>
            <?php else: ?>
                <li><span>No hay categorías disponibles.</span></li>
            <?php endif; ?>
        </ul>
    </div>

    <div class="filter-bar">
        <label for="ordenar">Ordenar por:</label>
        <select id="ordenar">
            <option value="precioBajoAlto">Precio: Bajo a Alto</option>
            <option value="precioAltoBajo">Precio: Alto a Bajo</option>
        </select>
    </div>

    <div class="main-products">
        <div class="product-items">
            <?php if ($productos_result->num_rows > 0): ?>
                <?php while ($producto = $productos_result->fetch_assoc()): ?>
                    <div class="product-card">
                        <div class="product-image">
                            <img src="<?php echo $producto['imagen_enlace'] ? 'public/images/' . htmlspecialchars($producto['imagen_enlace']) : 'https://via.placeholder.com/150'; ?>" 
                                alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                        </div>
                        <div class="product-info">
                            <h3 class="product-name"><?php echo htmlspecialchars($producto['nombre']); ?></h3>
                            <p class="product-price">US$<?php echo htmlspecialchars($producto['precio_venta']); ?></p>
                        </div>
                        <div class="product-action">
                            <a href="product-visualizer.php?codigo=<?php echo htmlspecialchars($producto['codigo']); ?>" class="btn-view" aria-label="Ver detalles de <?php echo htmlspecialchars($producto['nombre']); ?>">Ver Detalle</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No se encontraron productos.</p>
            <?php endif; ?>
        </div>
        <div class="pagination"></div>
    </div>
</main>
<?php include "reusables/footer.php"; ?>
</body>
</html>

<?php $mysql->close(); ?>
