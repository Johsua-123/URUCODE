<?php
session_start();
$location = "tienda";
require "api/mysql.php";

$stmt = $mysql->prepare("SELECT * FROM categorias WHERE eliminado = false");
$stmt->execute();
$categorias = $stmt->get_result();

$order = $_GET["order"] ?? null;
$query = $_GET["query"] ?? null;
$categoria = $_GET["categoria"] ?? null;

$productos = [];
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $busqueda = $mysql->real_escape_string($_GET['search']);
    $productos = $mysql->query("
        SELECT productos.*, imagenes.extension AS imagen_extension 
        FROM productos 
        LEFT JOIN imagenes ON productos.imagen_id = imagenes.codigo
        WHERE productos.en_venta = 1 AND (productos.nombre LIKE '%$busqueda%' 
        OR productos.marca LIKE '%$busqueda%' 
        OR productos.modelo LIKE '%$busqueda%' 
        OR productos.descripcion LIKE '%$busqueda%')
    ");
} else {
    


$orden = $order === "precioAltoBajo" ? "DESC" : "ASC"; 
$columnaOrden = "p.precio_venta";

$sql = "SELECT 
        p.*, 
        i.codigo AS 'i.codigo',
        i.nombre AS 'i.nombre',
        i.extension AS 'i.extension'
        FROM productos p
        LEFT JOIN imagenes i ON p.imagen_id = i.codigo
        LEFT JOIN productos_categorias pc ON pc.producto_id = p.codigo
        LEFT JOIN categorias c ON pc.categoria_id = c.codigo
        WHERE p.en_venta = true AND p.eliminado = false";

$params = [];
$tipos = "";

if (!empty($query)) {
    $sql .= " AND (p.nombre LIKE ? OR p.modelo LIKE ? OR p.marca LIKE ? OR p.descripcion LIKE ?)";
    $busqueda = "%$query%";
    $params = array_merge($params, [$busqueda, $busqueda, $busqueda, $busqueda]);
    $tipos .= "ssss";
}

if (!empty($categoria)) {
    $sql .= " AND c.nombre = ?";
    $params[] = $categoria;
    $tipos .= "s";
}

$sql .= " ORDER BY $columnaOrden $orden";

$stmt = $mysql->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($tipos, ...$params);
}

$stmt->execute();
$resultado = $stmt->get_result();

while ($producto = $resultado->fetch_assoc()) {
    $imagen = "public/images/imagen-vacia.png";
    if (!empty($producto["i.codigo"])) {
        $rutaImagen = "public/images/{$producto['i.nombre']}-{$producto['i.codigo']}{$producto['i.extension']}";
        if (file_exists($rutaImagen)) {
            $imagen = $rutaImagen;
        }
    }
    $producto["imagen"] = $imagen;

    unset($producto["i.codigo"], $producto["i.nombre"], $producto["i.extension"]);
    $productos[] = $producto;
}
}
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
                    <?php while ($categoria = $categorias->fetch_assoc()) { ?>
                        <li>
                            <a href="tienda.php?categoria=<?php echo $categoria["nombre"] ?? ""; ?>"><?php echo $categoria["nombre"] ?? ""; ?></a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <div class="filter-bar">
                <form method="GET" action="tienda.php">
                    <label for="ordenar">Ordenar por:</label>
                    <select id="ordenar" name="order" onchange="this.form.submit()">
                        <option value="precioBajoAlto" <?php echo !$order || $order == 'precioBajoAlto' ? 'selected' : ''; ?>>Precio: Bajo a Alto</option>
                        <option value="precioAltoBajo" <?php echo $order == 'precioAltoBajo' ? 'selected' : ''; ?>>Precio: Alto a Bajo</option>
                    </select>
                    <?php if (isset($_GET["query"])) { ?>
                        <input type="hidden" name="query" value="<?php echo $_GET["query"]; ?>">
                    <?php } ?>
                    <?php if (isset($_GET["categoria"])) { ?>
                        <input type="hidden" name="categoria" value="<?php echo $_GET["categoria"]; ?>">
                    <?php } ?>
                </form>
            </div>
            <div class="main-products">
                <div class="product-items">
                    <?php foreach ($productos as $producto) { ?>
                        <div class="product-card">
                            <div class="product-image">
                                <img src="<?php echo $producto["imagen"] ?? "public/images/imagen-vacia.png"; ?>" alt="<?php echo $producto["nombre"] ?? "imagen del producto"; ?>">
                            </div>
                            <div class="product-info">
                                <h3 class="product-name"><?php echo $producto["nombre"] ?? ""; ?></h3>
                                <p class="product-price">US$<?php echo $producto["precio_venta"] ?? ""; ?></p>
                            </div>
                            <div class="product-action">
                                <a href="visualizar.php?producto=<?php echo $producto["codigo"] ?? ""; ?>" class="btn-view">Ver Detalle</a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </main>
        <?php include "reusables/footer.php"; ?>
    </body>
</html>
