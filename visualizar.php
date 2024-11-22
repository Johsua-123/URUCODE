<?php

    session_start();

    $location = "tienda";

    require "api/mysql.php";
    
    $codigo = $_GET["producto"] ?? null;
    $producto = [];

    $stmt = $mysql->prepare("SELECT 
        p.* ,
        c.codigo AS 'c.codigo',
        c.nombre AS 'c.nombre',
        i.codigo AS 'i.codigo',
        i.nombre AS 'i.nombre',
        i.extension AS 'i.extension'
        FROM productos p
        LEFT JOIN imagenes i ON p.imagen_id=i.codigo
        LEFT JOIN productos_categorias pc ON pc.producto_id=p.codigo
        LEFT JOIN categorias c ON pc.categoria_id=c.codigo
        WHERE p.codigo=?
    ");

    $stmt->bind_param("i", $codigo);
    $stmt->execute();

    $resultado = $stmt->get_result();
    $producto = $resultado->fetch_assoc();

    if (!empty($producto["i.codigo"])) {
        $imagen = "public/images/{$producto['i.nombre']}-{$producto['i.codigo']}{$producto['i.extension']}";
        if (file_exists($imagen)) {
            $producto["imagen"] = $imagen;
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
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
        <link rel="stylesheet" href="assets/styles/header.css">
        <link rel="stylesheet" href="assets/styles/visualizar.css">
        <script src="assets/scripts/navbar.js"></script>
        <title> <?php echo $producto["nombre"] ?? "No encontrado"; ?> | Errea</title>
    </head>
    <body>
        <?php include "reusables/navbar.php"; ?>
        <main>
            <?php require "reusables/header.php"; ?>
            <div class="productos">
                <div class="producto">
                    <div class="producto-imagen">
                        <img src="<?php echo $producto["imagen"]; ?>" alt="<?php echo $producto["nombre"] ?? "imagen del producto"; ?>">
                    </div>
                    <div class="producto-info">
                        <div class="producto-titulo">
                            <h1><?php echo $producto["nombre"] ?? ""; ?></h1>
                            <h2>U$S <?php echo $producto["precio_venta"] ?? ""; ?></h2>
                        </div>
                        <div class="producto-detalles">
                            <span>
                                <p>Disponbilidad:</p>
                                <?php echo $producto["cantidad"] ?? ""; ?>
                            </span>
                            <span>
                                <p>Categoría:</p> 
                                <?php echo $producto["categoria_nombre"] ?? ""; ?>
                            </span>
                        </div>
                        <div class="botones">
                            <a href="compra.php?codigo=<?php echo $producto["codigo"] ?? ""; ?>">COMPRAR</a>
                            <form class="carrito" action="carrito.php" method="POST">
                                <input type="hidden" name="codigo" value="<?php echo $producto["codigo"] ?? ""; ?>">
                                <input type="hidden" name="nombre" value="<?php echo $producto["nombre"] ?? ""; ?>">
                                <input type="hidden" name="precio" value="<?php echo $producto["precio_venta"] ?? ""; ?>">
                                <input type="hidden" name="descripcion" value="<?php echo $producto["descripcion"] ?? ""; ?>">
                                <input type="hidden" name="accion" value="agregar">
                                <button type="submit">AÑADIR AL CARRITO</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="producto-descripcion <?php echo empty($producto["descripcion"]) ? "hidden" : ""; ?>">
                    <h1>DESCRIPCIÓN</h1>
                    <p><?php echo $producto["descripcion"] ?? ""; ?></p>
                </div>
            </div>
        </main>
        <?php include "reusables/footer.php"; ?>
    </body>
</html>
