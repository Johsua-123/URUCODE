<?php 

    session_start();

    $location = "tienda";

    require "api/mysql.php";

    $stmt = $mysql->prepare("SELECT * FROM categorias WHERE eliminado=false");
    $stmt->execute();
    $categorias = $stmt->get_result();

    $order = $_GET["order"] ?? null;
    $query = $_GET["query"] ?? null;

    $productos = [];

    if (!empty($query)) {
    
        $orden = "ASC";

        if (!empty($order) && $order == "precioAltoBajo") {
            $orden = "DESC";
        }

        $stmt = $mysql->prepare("SELECT 
            p.*
            i.codigo AS 'i.codigo',
            i.nombre AS 'i.nombre',
            i.extension AS 'i.extension'
            FROM productos p
            LEFT JOIN imagenes i ON productos.imagen_id=i.codigo
            WHERE p.en_venta=true AND p.eliminado=false
            AND (p.nombre LIKE ? OR p.modelo LIKE ? OR p.marca LIKE ? OR p.descripcion LIKE ?)
            ORDER BY $orden
        ");

        $busqueda = "%$query%";
        $stmt->bind_param("ssss", $busqueda, $busqueda, $busqueda, $busqueda);

        $stmt->execute();
        $resultado = $stmt->get_result();

        while ($producto = $resultado->fetch_assoc()) {
            if (!empty($producto["i.codigo"])) {
                $imagen = $producto["i.nombre"] . "-" . $producto["i.codigo"] . $producto["i.extension"];
                $producto["imagen"] = file_exists("public/images/$imagen") ? "public/images/$imagen" : "public/images/imagen-vacia.png";
            }
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
                    <select id="ordenar" name="orden" onchange="this.form.submit()">
                        <option value="precioBajoAlto" <?php echo $order == 'precioBajoAlto' ? 'selected' : ''; ?>>Precio: Bajo a Alto</option>
                        <option value="precioAltoBajo" <?php echo $order == 'precioAltoBajo' ? 'selected' : ''; ?>>Precio: Alto a Bajo</option>
                    </select>
                    <?php if (isset($_GET["query"])) { ?>
                        <input type="hidden" name="query" value="<?php echo $_GET["query"]; ?>">
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
        </main>
        <?php include "reusables/footer.php" ?>
    </body>
</html>