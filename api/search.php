<?php
$conexion = new mysqli("localhost", "duenio", "duenio", "urucode");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$resultado = [];

if ($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_GET["search"])) {
    $busqueda = $_GET['search'];
    $buscar = "SELECT * FROM productos WHERE en_venta = 1 AND (nombre LIKE '%$busqueda%' OR marca LIKE '%$busqueda%' OR modelo LIKE '%$busqueda%' OR descripcion LIKE '%$busqueda%')";
    $resultado = mysqli_query($conexion, $buscar);
}
?>
