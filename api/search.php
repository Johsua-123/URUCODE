<?php
$conexion = new mysqli("localhost", "duenio", "duenio", "urucode");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$resultado = [];

if ($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_GET["search"])) {
    $busqueda = $conexion->real_escape_string($_GET['search']);
    $buscar = "
        SELECT productos.*, CONCAT(imagenes.nombre, imagenes.extension) AS imagen_enlace
        FROM productos
        LEFT JOIN imagenes ON productos.imagen_id = imagenes.codigo
        WHERE productos.en_venta = 1 AND (
            productos.nombre LIKE '%$busqueda%' OR 
            productos.marca LIKE '%$busqueda%' OR 
            productos.modelo LIKE '%$busqueda%' OR 
            productos.descripcion LIKE '%$busqueda%'
        )
    ";
    $resultado = mysqli_query($conexion, $buscar);
}
?>
