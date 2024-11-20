<?php
    session_start();

    $location = "inicio";

    require 'api/mysql.php';

    // Consulta para "Destacados"
    $stmt = $mysql->prepare("SELECT 
        p.*,
        i.codigo AS 'i.codigo',
        i.nombre AS 'i.nombre',
        i.extension AS 'i.extension'
        FROM productos p
        LEFT JOIN imagenes i ON p.imagen_id=i.codigo 
        LEFT JOIN productos_categorias pc ON pc.producto_id=p.codigo 
        LEFT JOIN categorias c ON pc.categoria_id=c.codigo 
        WHERE p.en_venta=true AND c.nombre='Destacados'
    ");

    $stmt->execute();
    $resultado = $stmt->get_result();
    $destacados = [];

    while ($producto = $resultado->fetch_assoc()) {
        if (!empty($producto["i.codigo"])) {
            $imagen = $producto["i.nombre"] . "-" . $producto["i.codigo"] . $producto["i.extension"];
            if (file_exists("public/images/$imagen")) {
                $producto["imagen"] = "public/images/$imagen";
            } else {
                $producto["imagen"] = "";
            }
        }
        unset($producto["i.codigo"], $producto["i.nombre"], $producto["i.extension"]);
        $destacados[] = $producto;
    }

    // Consulta para "Ofertas"
    $stmt = $mysql->prepare("SELECT 
        p.*,
        i.codigo AS 'i.codigo',
        i.nombre AS 'i.nombre',
        i.extension AS 'i.extension'
        FROM productos p
        LEFT JOIN imagenes i ON p.imagen_id=i.codigo 
        LEFT JOIN productos_categorias pc ON pc.producto_id=p.codigo 
        LEFT JOIN categorias c ON pc.categoria_id=c.codigo 
        WHERE p.en_venta=true AND c.nombre='Ofertas'
    ");

    $stmt->execute();
    $resultado = $stmt->get_result();
    $ofertas = [];

    while ($producto = $resultado->fetch_assoc()) {
        if (!empty($producto["i.codigo"])) {
            $imagen = $producto["i.nombre"] . "-" . $producto["i.codigo"] . $producto["i.extension"];
            if (file_exists("public/images/$imagen")) {
                $producto["imagen"] = "public/images/$imagen";
            } else {
                $producto["imagen"] = "";
            }
        }
        unset($producto["i.codigo"], $producto["i.nombre"], $producto["i.extension"]);
        $ofertas[] = $producto;
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
    <link rel="stylesheet" href="assets/styles/master.css">
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
        <div class="main-products">
            <h1>Destacados</h1>
            <div class="product-items">
                <?php foreach ($destacados as $producto) { ?>
                    <div class="product-card">
                        <div class="card-header">
                            <img src="<?php echo $producto["imagen"] ?>" alt="<?php echo $producto["nombre"]; ?>">
                        </div>
                        <div class="card-items">
                            <h1><?php echo $producto["nombre"]; ?></h1>
                            <h2>U$S <?php echo $producto["precio_venta"]; ?></h2>
                        </div>
                        <div class="card-footer">
                            <a href="ver-product.php?producto=<?php echo $producto["codigo"]; ?>">Ver detalles</a>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="picture">
                <img src="public/banners/12Cuotas_MiniBanner-v2-1024x123.png" alt="#">
            </div>
        </div>
        <div class="main-products">
            <h1>Ofertas</h1>
            <div class="product-items">
                <?php foreach ($ofertas as $producto) { ?>
                    <div class="product-card">
                        <div class="card-header">
                            <img src="<?php echo $producto["imagen"] ?>" alt="<?php echo $producto["nombre"]; ?>">
                        </div>
                        <div class="card-items">
                            <h1><?php echo $producto["nombre"]; ?></h1>
                            <h2>U$S <?php echo $producto["precio_venta"]; ?></h2>
                        </div>
                        <div class="card-footer">
                            <a href="ver-producto.php?producto=<?php echo $producto["codigo"]; ?>">Ver detalles</a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </main>
    <?php include "reusables/footer.php"; ?>
</body>
</html>
