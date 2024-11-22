<?php

    session_start();

    $location = "tienda";

    require "api/mysql.php";

    $productos = [];

    // datos recibidos 
    $categoria = $_GET["categoria"] ?? null;
    $buscar = $_GET["buscar"] ?? null;
    $filtro = $_GET["filtro"] ?? null;
    $tamaño = $_GET["tamaño"] ?? 12;
    $pagina = $_GET["pagina"] ?? 1;

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

        // contamos
        $consulta .= "AND c.codigo=?";
        $stmt = $mysql->prepare($consulta);

        $stmt->bind_param("i", $categoria);
        $stmt->execute();

        $total = $stmt->get_result()->fetch_assoc()["total"];

        // paginacion
        $paginas = ceil($total / $tamaño);
        $ignorar = ($pagina - 1) * $tamaño;
        
        // consulta
        $stmt = $mysql->prepare("SELECT
            p.codigo, p.nombre, p.precio_venta,
            i.codigo AS 'i.codigo', i.nombre AS 'i.nombre', i.extension AS 'i.extension'
            FROM productos p
            JOIN imagenes i ON p.imagen_id=i.codigo
            JOIN productos_categorias pc ON pc.producto_id=p.codigo
            JOIN categorias c ON pc.categoria_id=c.codigo
            WHERE p.en_venta=true AND p.eliminado=false AND c.eliminado=false AND c.codigo=?
            ORDER BY p.precio_venta $orden
            LIMIT $ignorar, $tamaño
        ");

        $stmt->bind_param("i", $categoria);

        $stmt->execute();
        $resultado = $stmt->get_result();

        // resultados
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

    if (empty($categoria)) {

        // paginacion
        $paginas = ceil($total / $tamaño);
        $ignorar = ($pagina - 1) * $tamaño;

        // consulta
        $stmt = $mysql->prepare("SELECT
            p.codigo, p.nombre, p.precio_venta,
            i.codigo AS 'i.codigo', i.nombre AS 'i.nombre', i.extension AS 'i.extension'
            FROM productos p
            JOIN imagenes i ON p.imagen_id=i.codigo
            JOIN productos_categorias pc ON pc.producto_id=p.codigo
            JOIN categorias c ON pc.categoria_id=c.codigo
            WHERE p.en_venta=true AND p.eliminado=false AND c.eliminado=false
            ORDER BY p.precio_venta $orden
            LIMIT $ignorar, $tamaño
        ");

        $stmt->execute();
        $resultado = $stmt->get_result();

        // resultados
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

    if (!empty($buscar)) {

        $consulta = "SELECT
            p.codigo, p.nombre, p.precio_venta,
            i.codigo AS 'i.codigo', i.nombre AS 'i.nombre', i.extension AS 'i.extension'
            FROM productos p
            JOIN imagenes i ON p.imagen_id=i.codigo
            JOIN productos_categorias pc ON pc.producto_id=p.codigo
            JOIN categorias c ON pc.categoria_id=c.codigo
            WHERE p.en_venta=true AND p.eliminado=false AND c.eliminado=false
        ";

        if (!empty($categoria)) {
            
            $consulta .= "AND c.codigo=?";
            $consulta .= " AND p.nombre LIKE '%$buscar%'";

            $consulta .= "ORDER BY p.precio_venta $orden";
            $stmt = $mysql->prepare($consulta);

            $stmt->bind_param("i", $categoria);
            $stmt->execute();

        }
        
        if (empty($categoria)) {
            
            $consulta .= " AND p.nombre LIKE '%$buscar%' ";

            $consulta .= " ORDER BY p.precio_venta $orden";
            $stmt = $mysql->prepare($consulta);

            $stmt->execute();

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
            <div class="categorias">
                <h2>Todas las Categorías</h2>
                <div class="categorias-lista">
                    <?php 

                        $stmt = $mysql->prepare("SELECT 
                            c.codigo, c.nombre
                            FROM categorias c
                            JOIN productos_categorias pc ON pc.categoria_id=c.codigo
                            JOIN productos p ON pc.producto_id=p.codigo
                            WHERE c.eliminado=false AND p.eliminado=false AND p.en_venta=true
                            GROUP BY c.codigo
                        ");

                        $stmt->execute();
                        $resultado = $stmt->get_result();
                    
                        while ($categoria = $resultado->fetch_assoc()) { ?>
                        <a href="tienda.php?categoria=<?php echo $categoria["codigo"] ?? ""; ?>"><?php echo $categoria["nombre"] ?? ""; ?></a>
                    <?php } ?>
                </div>
            </div>
            <section class="tienda">
                <div class="cabezera">
                    <form class="filtros" method="GET">
                        <label for="ordenar">Ordenar por:</label>
                        <input type="hidden" name="categoria" value="<?php echo $_SESSION["categoria"] ?? ""; ?>">
                        <select id="ordenar" name="filtro" onchange="this.form.submit()">
                            <option value="bajo" <?php echo $filtro == "bajo" ? "selected" : ""; ?>>Precio: Bajo a Alto</option>
                            <option value="alto" <?php echo $filtro == "alto" ? "selected" : ""; ?>>Precio: Alto a Bajo</option>
                        </select>
                    </form>
                    <div class="paginas">
                        <span><?php echo "$pagina / $paginas"; ?></span>
                    </div>
                </div>
                <div class="productos">
                    <?php foreach ($productos as $producto) { ?>
                        <div class="producto">
                            <div class="producto-header">
                                <img src="<?php echo $producto["imagen"] ?? "public/images/imagen-vacia.png" ?>" alt="imagen del producto">
                            </div>
                            <div class="producto-cuerpo">
                                <span><?php echo $producto["nombre"] ?? ""; ?></span>
                                <span>U$S <?php echo $producto["precio_venta"] ?? ""; ?></span>
                            </div>
                            <div class="producto-footer">
                                <a href="visualizar.php?producto=<?php echo $producto["codigo"]; ?>">Ver detalles</a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="tienda-footer">
                    <a href="tienda.php?categoria=<?php echo $_SESSION["categoria"] ?? ""; ?>&pagina=<?php echo ($pagina == 1) ? $paginas : $pagina - 1; ?>">
                        Anterior
                    </a>
                    <a href="tienda.php?categoria=<?php echo $_SESSION["categoria"] ?? ""; ?>&pagina=<?php echo ($pagina == $paginas) ? 1 : $pagina + 1; ?>">
                        Siguiente
                    </a>
                </div>
            </section>
        </main>
        <?php include "reusables/footer.php"; ?>
    </body>
</html>
