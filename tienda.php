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
$page = $_GET["page"] ?? 1;
$productos_por_pagina = 12;
$offset = ($page - 1) * $productos_por_pagina;

$productos = [];
$productos_total = 0;

$orden = $order === "precioAltoBajo" ? "DESC" : "ASC"; 
$columnaOrden = "p.precio_venta";

$sql_base = "FROM productos p
             LEFT JOIN imagenes i ON p.imagen_id = i.codigo
             LEFT JOIN productos_categorias pc ON pc.producto_id = p.codigo
             LEFT JOIN categorias c ON pc.categoria_id = c.codigo
             WHERE p.en_venta = true AND p.eliminado = false";

$params = [];
$tipos = "";

if (!empty($query)) {
    $sql_base .= " AND (p.nombre LIKE ? OR p.modelo LIKE ? OR p.marca LIKE ? OR p.descripcion LIKE ?)";
    $busqueda = "%$query%";
    $params = array_merge($params, [$busqueda, $busqueda, $busqueda, $busqueda]);
    $tipos .= "ssss";
}

if (!empty($categoria)) {
    $sql_base .= " AND c.nombre = ?";
    $params[] = $categoria;
    $tipos .= "s";
}

// Obtiene el total de productos
$sql_count = "SELECT COUNT(*) AS total $sql_base";
$stmt = $mysql->prepare($sql_count);

if (!empty($params)) {
    $stmt->bind_param($tipos, ...$params);
}

$stmt->execute();
$resultado = $stmt->get_result();
$row = $resultado->fetch_assoc();
$productos_total = $row['total'];

// Calcula el número total de páginas
$total_paginas = ceil($productos_total / $productos_por_pagina);

// Obtiene los productos de la página actual
$sql_productos = "SELECT 
                   p.*, 
                   i.codigo AS 'i_codigo',
                   i.nombre AS 'i_nombre',
                   i.extension AS 'i_extension'
                   $sql_base
                   ORDER BY $columnaOrden $orden
                   LIMIT $productos_por_pagina OFFSET $offset";
$stmt = $mysql->prepare($sql_productos);

if (!empty($params)) {
    $stmt->bind_param($tipos, ...$params);
}

$stmt->execute();
$resultado = $stmt->get_result();

while ($producto = $resultado->fetch_assoc()) {
    $imagen = "public/images/imagen-vacia.png";
    if (!empty($producto["i_codigo"])) {
        $rutaImagen = "public/images/{$producto['i_nombre']}-{$producto['i_codigo']}{$producto['i_extension']}";
        if (file_exists($rutaImagen)) {
            $imagen = $rutaImagen;
        }
    }
    $producto["imagen"] = $imagen;
    unset($producto["i_codigo"], $producto["i_nombre"], $producto["i_extension"]);
    $productos[] = $producto;
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
                <div class="pagination">
                    <?php for ($i = 1; $i <= $total_paginas; $i++) { ?>
                        <a href="tienda.php?page=<?php echo $i; ?>" class="<?php echo $i == $page ? 'active' : ''; ?>"><?php echo $i; ?></a>
                    <?php } ?>
                </div>
            </div>
        </main>
        <?php include "reusables/footer.php"; ?>
    </body>
</html>
