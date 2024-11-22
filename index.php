<?php

    session_start();

    $location = "inicio";

    require "api/mysql.php";

    function obtenerProductos($mysql, $categoria) {
        $stmt = $mysql->prepare("SELECT 
            p.*,
            i.codigo AS 'i.codigo',
            i.nombre AS 'i.nombre',
            i.extension AS 'i.extension'
            FROM productos p
            LEFT JOIN imagenes i ON p.imagen_id=i.codigo 
            LEFT JOIN productos_categorias pc ON pc.producto_id=p.codigo 
            LEFT JOIN categorias c ON pc.categoria_id=c.codigo 
            WHERE p.en_venta=true AND p.eliminado=false AND c.nombre=? AND c.eliminado=false
            ORDER BY p.precio_venta ASC
        ");

        $stmt->bind_param("s", $categoria);
        $stmt->execute();
        
        $resultado = $stmt->get_result();
        $productos = [];

        while ($producto = $resultado->fetch_assoc()) {
            if (!empty($producto["i.codigo"])) {
                $imagen = "public/images/" . $producto["i.nombre"] . "-" . $producto["i.codigo"] . $producto["i.extension"];
                $producto["imagen"] = file_exists($imagen) ? $imagen : "public/images/imagen-vacia.png";
            }
            unset($producto["i.codigo"], $producto["i.nombre"], $producto["i.extension"]);
            $productos[] = $producto;
        }

        return $productos;
    }

    $destacados = obtenerProductos($mysql, "Destacados");
    $ofertas = obtenerProductos($mysql, "Ofertas");

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
    <link rel="shortcut icon" href="public/icons/errea.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/styles/module.css">
    <link rel="stylesheet" href="assets/styles/navbar.css">
    <link rel="stylesheet" href="assets/styles/footer.css">
    <link rel="stylesheet" href="assets/styles/index.css">
    <script src="assets/scripts/navbar.js"></script>
    <script src="assets/scripts/slider.js"></script>
    <title>Inicio | Errea</title>
</head>
<body>
    <?php include "reusables/navbar.php"; ?>
    <main>
        <div class="slider">
            <div id="slider" class="slides">
                <img src="public/banners/slider-1.png" alt="slider image 1">
                <img src="public/banners/slider-2.png" alt="slider image 2">
                <img src="public/banners/slider-3.png" alt="slider image 3">
                <img src="public/banners/slider-4.png" alt="slider image 4">
                <img src="public/banners/slider-5.png" alt="slider image 5">
            </div>
        </div>
        <section class="productos-principales">
            <h1>Destacados</h1>
            <div class="productos">
                <?php foreach ($destacados as $producto) { ?>
                    <div class="producto">
                        <div class="producto-header">
                            <img src="<?php echo $producto["imagen"] ?? "public/images/imagen-vacia.png"; ?>" alt="<?php echo $producto["nombre"]; ?>">
                        </div>
                        <div class="producto-cuerpo">
                            <span><?php echo $producto["nombre"]; ?></span>
                            <span>U$S <?php echo $producto["precio_venta"]; ?></span>
                        </div>
                        <div class="producto-footer">
                            <a href="visualizar.php?producto=<?php echo $producto["codigo"]; ?>">Ver detalles</a>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="banner">
                <img src="public/banners/cuotas.png" alt="#">
            </div>
        </section>
            <section class="productos-principales">
                <h1>Ofertas</h1>
                <div class="productos">
                    <?php foreach ($ofertas as $producto) { ?>
                        <div class="producto">
                            <div class="producto-header">
                                <img src="<?php echo $producto["imagen"] ?? "public/images/imagen-vacia.png"; ?>" alt="<?php echo $producto["nombre"]; ?>">
                            </div>
                            <div class="producto-cuerpo">
                                <span><?php echo $producto["nombre"]; ?></span>
                                <span>U$S <?php echo $producto["precio_venta"]; ?></span>
                            </div>
                            <div class="producto-footer">
                                <a href="visualizar.php?producto=<?php echo $producto["codigo"]; ?>">Ver detalles</a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </section>
        </main>
        <?php include "reusables/footer.php"; ?>
    </body>
</html>
