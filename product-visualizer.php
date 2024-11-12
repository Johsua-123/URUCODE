
<?php 
session_start();
$location = "tienda";

define("URUCODE", true);
require 'api/mysql.php';

if (isset($_GET['codigo'])) {
    $product_code = $_GET['codigo'];

    $servername = "localhost";
    $username = "duenio";
    $password = "duenio";
    $dbname = "urucode";

    $mysql = new mysqli($servername, $username, $password, $dbname);
    if ($mysql->connect_error) {
        die("Error de conexión a la base de datos: " . $mysql->connect_error);
    }

    // Consulta para obtener el producto
    $stmt = $mysql->prepare("SELECT * FROM productos WHERE codigo = ?");
    $stmt->bind_param("i", $product_code);
    $stmt->execute();
    $result = $stmt->get_result();
    $producto = $result->fetch_assoc();

    // Verificar si el producto fue encontrado
    if ($producto) {
        // Obtener la imagen del producto desde la tabla imagenes
        $imagen_id = $producto['imagen_id'];
        $stmt = $mysql->prepare("SELECT nombre FROM imagenes WHERE codigo = ?");
        $stmt->bind_param("i", $imagen_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $imagen = $result->fetch_assoc();

        $imagen_url = $imagen ? 'ruta/a/imagenes/' . $imagen['nombre'] : 'https://via.placeholder.com/150'; // Reemplaza 'ruta/a/imagenes/' con la ruta correcta
    } else {
        echo "Producto no encontrado.";
        exit;
    }

    $stmt->close();
    $mysql->close();
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
            <p>HOME > TIENDA > <?php echo isset($producto['categoria']) ? htmlspecialchars($producto['categoria']) : 'Categoría no encontrada'; ?> > <?php echo isset($producto['nombre']) ? htmlspecialchars($producto['nombre']) : 'Producto no encontrado'; ?></p>
        </div>
        <div class="product">
            <div class="product-image">
                <img src="<?php echo htmlspecialchars($imagen_url); ?>" alt="<?php echo isset($producto['nombre']) ? htmlspecialchars($producto['nombre']) : 'Imagen no encontrada'; ?>">
            </div>
            <div class="product-info">
                <h1><?php echo isset($producto['nombre']) ? htmlspecialchars($producto['nombre']) : 'Producto no encontrado'; ?></h1>
                <H2>US$<?php echo isset($producto['precio_venta']) ? htmlspecialchars($producto['precio_venta']) : '0.00'; ?></H2>
                <p><?php echo isset($producto['descripcion']) ? htmlspecialchars($producto['descripcion']) : 'Descripción no disponible'; ?></p>
                <a href="#">COMPRAR</a>
            </div>
        </div>
        <div class="product-images">
            <img src="<?php echo htmlspecialchars($imagen_url); ?>" alt="<?php echo isset($producto['nombre']) ? htmlspecialchars($producto['nombre']) : 'Imagen no encontrada'; ?>">
            <!-- Añadir más imágenes si es necesario -->
        </div>
        <div class="product-description">
            <h1>DESCRIPCIÓN</h1>
            <p><?php echo isset($producto['descripcion']) ? htmlspecialchars($producto['descripcion']) : 'Descripción no disponible'; ?></p>
        </div>
        <div class="related-products">
            <h1>PRODUCTOS RELACIONADOS</h1>
            <div class="related-products_images">
                <img src="<?php echo htmlspecialchars($imagen_url); ?>" alt="<?php echo isset($producto['nombre']) ? htmlspecialchars($producto['nombre']) : 'Imagen no encontrada'; ?>">
                <!-- Añadir productos relacionados dinámicamente -->
            </div>
        </div>
    </main>
    <?php include "reusables/footer.php" ?>
</body>
</html>
