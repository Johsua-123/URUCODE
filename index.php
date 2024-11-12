<?php
session_start();
$location = "index";
require 'api/mysql.php';

// productos destacados
$stmt_destacados = $mysql->prepare("SELECT productos.*, imagenes.nombre AS imagen_nombre 
                                    FROM productos 
                                    LEFT JOIN imagenes ON productos.imagen_id = imagenes.codigo 
                                    LEFT JOIN productos_categorias ON productos.codigo = productos_categorias.producto_id 
                                    LEFT JOIN categorias ON productos_categorias.categoria_id = categorias.codigo 
                                    WHERE productos.en_venta = true AND categorias.nombre = 'Destacados'");
$stmt_destacados->execute();
$productos_destacados = $stmt_destacados->get_result();
$stmt_destacados->close();

// productos en oferta
$stmt_ofertas = $mysql->prepare("SELECT productos.*, imagenes.nombre AS imagen_nombre 
                                 FROM productos 
                                 LEFT JOIN imagenes ON productos.imagen_id = imagenes.codigo 
                                 LEFT JOIN productos_categorias ON productos.codigo = productos_categorias.producto_id 
                                 LEFT JOIN categorias ON productos_categorias.categoria_id = categorias.codigo 
                                 WHERE productos.en_venta = true AND categorias.nombre = 'Ofertas'");
$stmt_ofertas->execute();
$productos_ofertas = $stmt_ofertas->get_result();
$stmt_ofertas->close();
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
    <link rel="shortcut icon" href="public/icons/logo.png" type="image/x-icon">
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
                <?php while ($producto = $productos_destacados->fetch_assoc()) { 
                    $imagen_url = $producto['imagen_nombre'] ? 'public/images/' . $producto['imagen_nombre'] : 'https://via.placeholder.com/100x100?text=Imagen+del+Producto'; 
                ?>
                    <div class="product-card">
                        <div class="card-header">
                            <img src="<?php echo htmlspecialchars($imagen_url); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                        </div>
                        
                        <div class="card-items">
                            <h1><?php echo htmlspecialchars($producto['nombre']); ?></h1>
                            <h2>U$S <?php echo htmlspecialchars($producto['precio_venta']); ?></h2>
                        </div>
                        <div class="card-footer">
                            <a href="product-visualizer.php?codigo=<?php echo htmlspecialchars($producto['codigo']); ?>">Ver detalles</a>
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
                <?php while ($producto = $productos_ofertas->fetch_assoc()) { 
                 $imagen_url = $producto['imagen_nombre'] ? 'public/images/' . urlencode($producto['imagen_nombre']) : 'https://via.placeholder.com/100x100?text=Imagen+del+Producto';
                ?>
                    <div class="product-card">
                        <div class="card-header">
                            <img src="<?php echo htmlspecialchars($imagen_url); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                        </div>
                        <div class="card-items">
                            <h1><?php echo htmlspecialchars($producto['nombre']); ?></h1>
                            <h2>U$S <?php echo htmlspecialchars($producto['precio_venta']); ?></h2>
                        </div>
                        <div class="card-footer">
                            <a href="product-visualizer.php?codigo=<?php echo htmlspecialchars($producto['codigo']); ?>">Ver detalles</a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </main>
    <?php include "reusables/footer.php"; ?>
</body>
</html>
