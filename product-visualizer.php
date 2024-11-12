<?php

    session_start();
    $location = "tienda";

    require 'api/mysql.php';

if (isset($_GET['codigo'])) {
    $product_code = $_GET['codigo'];

    $servername = "localhost";
    $username = "duenio";
    $password = "duenio";
    $dbname = "urucode";

    $stmt = $mysql->prepare("SELECT * FROM productos WHERE codigo = ?");
    $stmt->bind_param("i", $product_code);
    $stmt->execute();
    $result = $stmt->get_result();
    $producto = $result->fetch_assoc();

    if ($producto) {
        $imagen_id = $producto['imagen_id'];
        $stmt = $mysql->prepare("SELECT nombre FROM imagenes WHERE codigo = ?");
        $stmt->bind_param("i", $imagen_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $imagen = $result->fetch_assoc();
        $imagen_url = $imagen ? 'public/images/' . $imagen['nombre'] : 'https://via.placeholder.com/150';

        // Obtener la categoría del producto
        $stmt = $mysql->prepare("SELECT categorias.nombre AS categoria_nombre FROM categorias 
                                 JOIN productos_categorias ON categorias.codigo = productos_categorias.categoria_id 
                                 WHERE productos_categorias.producto_id = ?");
        $stmt->bind_param("i", $product_code);
        $stmt->execute();
        $result = $stmt->get_result();
        $categoria = $result->fetch_assoc();
        $categoria_nombre = $categoria ? $categoria['categoria_nombre'] : 'Categoría no encontrada';

    } else {
        echo "Producto no encontrado.";
        exit;
    }

    } else {
        echo "Código de producto no especificado.";
        exit;
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
    <title>Producto | Errea</title>
    <link rel="shortcut icon" href="public/icons/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/styles/module.css">
    <link rel="stylesheet" href="assets/styles/navbar.css">
    <link rel="stylesheet" href="assets/styles/footer.css">
    <link rel="stylesheet" href="assets/styles/product-visualizer.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/scripts/navbar.js"></script>
</head>
<body>
    <?php include "reusables/navbar.php" ?>
    <main>
        <div class="web-path">
            <p>HOME > TIENDA > <?php echo htmlspecialchars($categoria_nombre); ?> > <?php echo htmlspecialchars($producto['nombre']); ?></p>
        </div>
        <div class="product">
            <div class="product-image">
                <img src="<?php echo htmlspecialchars($imagen_url); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
            </div>
            <div class="product-info">
                <h1><?php echo htmlspecialchars($producto['nombre']); ?></h1>
                <H2>US$<?php echo htmlspecialchars($producto['precio_venta']); ?></H2>
                <p><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                <a href="checkout.php?codigo=<?php echo $product_code; ?>">COMPRAR</a>
            </div>
        </div>
        <div class="product-images">
            <img src="<?php echo htmlspecialchars($imagen_url); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
        </div>
        <div class="product-description">
            <h1>DESCRIPCIÓN</h1>
            <p><?php echo htmlspecialchars($producto['descripcion']); ?></p>
        </div>
        <div class="related-products">
            <h1>PRODUCTOS RELACIONADOS</h1>
            <div class="related-products_images">
                <img src="<?php echo htmlspecialchars($imagen_url); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
            </div>
        </div>
    </main>
    <?php include "reusables/footer.php" ?>
</body>
</html>
