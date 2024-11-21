<?php

    session_start();

    $location = "tienda";

    require "api/mysql.php";

    $stmt = $mysql->prepare("SELECT 
        c.codigo, c.nombre
        FROM categorias c
        JOIN productos_categorias pc ON pc.categoria_id=c.codigo
        JOIN productos p ON pc.producto_id=p.codigo
        WHERE c.eliminado=false AND p.eliminado=false AND p.en_venta=true
        GROUP BY c.codigo
    ");

    $stmt->execute();
    $categorias = $stmt->get_result();

    $productos = [];

    // datos recibidos 
    $categoria = $_GET["categoria"] ?? null;
    $buscar = $_GET["buscar"] ?? null;
    $filtro = $_GET["filtro"] ?? null;

    $_SESSION["categoria"] = $categoria;
    $orden = "ASC";
    $total = 0;

    // aplicamos filtros
    if (!empty($filtro) && $filtro == "alto") {
        $orden = "DESC";
    }

    $consulta = "SELECT
        COUNT(p.codigo) 'total'
        FROM productos p
        JOIN productos_categorias pc ON pc.producto_id=p.codigo
        JOIN categorias c ON pc.categoria_id=c.codigo
        WHERE p.en_venta=true AND p.eliminado=false AND c.eliminado=false
    ";

    $stmt = $mysql->prepare($consulta);
    $stmt->execute();

    $total = $stmt->get_result()->fetch_assoc()["total"];

    // categoria seleccionada
    if (!empty($categoria)) {

        // contar productos
        $consulta .= "AND c.codigo=?";
        $stmt = $mysql->prepare($consulta);

        $stmt->bind_param("i", $categoria);
        $stmt->execute();

        $total = $stmt->get_result()->fetch_assoc()["total"];
        
        // obtenemos productos
        $stmt = $mysql->prepare("SELECT
            p.codigo, p.nombre, p.precio_venta,
            i.codigo AS 'i.codigo', i.nombre AS 'i.nombre', i.extension AS 'i.extension'
            FROM productos p
            JOIN imagenes i ON p.imagen_id=i.codigo
            JOIN productos_categorias pc ON pc.producto_id=p.codigo
            JOIN categorias c ON pc.categoria_id=c.codigo
            WHERE p.en_venta=true AND p.eliminado=false AND c.eliminado=false AND c.codigo=?
            ORDER BY p.precio_venta $orden
        ");

        $stmt->bind_param("i", $categoria);

        $stmt->execute();
        $resultado = $stmt->get_result();

        // obtenemos resultados
        while ($producto = $resultado->fetch_assoc()) {
            if (!empty($producto["i.codigo"])) {
                $imagen = "public/images/{$producto['i.nombre']}-{$producto['i.codigo']}{$producto['i.extension']}";
                if (file_exists($imagen)) {
                    $producto["imagen"] = $imagen;
                }
            }
            unset($producto["i.codigo"], $producto["i.nombre"], $producto["i.extension"]);
            $productos[] = $producto;
        }

    }

    $stmt = $mysql->prepare("SELECT
        p.codigo, p.nombre, p.precio_venta,
        i.codigo AS 'i.codigo', i.nombre AS 'i.nombre', i.extension AS 'i.extension'
        FROM productos p
        JOIN imagenes i ON p.imagen_id=i.codigo
        JOIN productos_categorias pc ON pc.producto_id=p.codigo
        JOIN categorias c ON pc.categoria_id=c.codigo
        WHERE p.en_venta=true AND p.eliminado=false AND c.eliminado=false
        ORDER BY p.precio_venta $orden
    ");

    $stmt->execute();
    $resultado = $stmt->get_result();

    // obtenemos resultados
    while ($producto = $resultado->fetch_assoc()) {
        if (!empty($producto["i.codigo"])) {
            $imagen = "public/images/{$producto['i.nombre']}-{$producto['i.codigo']}{$producto['i.extension']}";
            if (file_exists($imagen)) {
                $producto["imagen"] = $imagen;
            }
        }
        unset($producto["i.codigo"], $producto["i.nombre"], $producto["i.extension"]);
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
                            <a href="tienda.php?categoria=<?php echo $categoria["codigo"] ?? ""; ?>"><?php echo $categoria["nombre"] ?? ""; ?></a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <div class="filter-bar">
                <form method="GET">
                    <label for="ordenar">Ordenar por:</label>
                    <input type="hidden" name="categoria" value="<?php echo $_SESSION["categoria"] ?? ""; ?>">
                    <select id="ordenar" name="filtro" onchange="this.form.submit()">
                        <option value="bajo" <?php echo $filtro == "bajo" ? "selected" : ""; ?>>Precio: Bajo a Alto</option>
                        <option value="alto" <?php echo $filtro == "alto" ? "selected" : ""; ?>>Precio: Alto a Bajo</option>
                    </select>
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
                    
                </div>
            </div>
        </main>
        <?php include "reusables/footer.php"; ?>
    </body>
</html>
