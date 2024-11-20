<?php
session_start();
$location = "inicio";

require 'api/mysql.php';

// Función para obtener productos
function obtenerProductos($mysql, $categoria) {
    $stmt = $mysql->prepare("
        SELECT 
            p.*,
            i.codigo AS 'i.codigo',
            i.nombre AS 'i.nombre',
            i.extension AS 'i.extension'
        FROM productos p
        LEFT JOIN imagenes i ON p.imagen_id = i.codigo 
        LEFT JOIN productos_categorias pc ON pc.producto_id = p.codigo 
        LEFT JOIN categorias c ON pc.categoria_id = c.codigo 
        WHERE p.en_venta = true AND c.nombre = ?
    ");
    $stmt->bind_param("s", $categoria);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $productos = [];

    while ($producto = $resultado->fetch_assoc()) {
        $producto["imagen"] = generarRutaImagen($producto);
        unset($producto["i.codigo"], $producto["i.nombre"], $producto["i.extension"]);
        $productos[] = $producto;
    }

    return $productos;
}

// Función para generar la ruta de la imagen
function generarRutaImagen($producto) {
    if (!empty($producto["i.codigo"])) {
        $imagen = $producto["i.nombre"] . "-" . $producto["i.codigo"] . $producto["i.extension"];
        $ruta = "public/images/$imagen";
        return file_exists($ruta) ? $ruta : "";
    }
    return "";
}

// Obtener productos destacados y ofertas
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
    <link rel="stylesheet" href="assets/styles/master.css">
    <script src="assets/scripts/navbar.js"></script>
    <script src="assets/scripts/slider.js"></script>
    <title>Inicio | Errea</title>
</head>
<body>
    <?php include "reusables/navbar.php"; ?>
    <main>
        <!-- Slider -->
        <div class="slider">
            <div id="slider" class="slides">
                <img src="public/banners/slider-1.png" alt="slider image 1">
                <img src="public/banners/slider-2.png" alt="slider image 2">
                <img src="public/banners/slider-3.png" alt="slider image 3">
                <img src="public/banners/slider-4.png" alt="slider image 4">
                <img src="public/banners/slider-5.png" alt="slider image 5">
            </div>
        </div>

        <!-- Productos Destacados -->
        <section class="main-products">
            <h1>Destacados</h1>
            <div class="product-items">
                <?php foreach ($destacados as $producto): ?>
                    <?php incluirProducto($producto); ?>
                <?php endforeach; ?>
            </div>
            <div class="picture">
                <img src="public/banners/12Cuotas_MiniBanner-v2-1024x123.png" alt="#">
            </div>
        </section>

        <!-- Productos en Oferta -->
        <section class="main-products">
            <h1>Ofertas</h1>
            <div class="product-items">
                <?php foreach ($ofertas as $producto): ?>
                    <?php incluirProducto($producto); ?>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
    <?php include "reusables/footer.php"; ?>
</body>
</html>

<?php
// Función para incluir un producto
function incluirProducto($producto) {
    ?>
    <div class="product-card">
        <div class="card-header">
            <img src="<?php echo $producto["imagen"] ?: "public/images/imagen-vacia.png"; ?>" alt="<?php echo $producto["nombre"]; ?>">
        </div>
        <div class="card-items">
            <h1><?php echo $producto["nombre"]; ?></h1>
            <h2>U$S <?php echo $producto["precio_venta"]; ?></h2>
        </div>
        <div class="card-footer">
            <a href="visualizar.php?producto=<?php echo $producto["codigo"]; ?>">Ver detalles</a>
        </div>
    </div>
    <?php
}
?>
