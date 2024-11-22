<?php
require "mysql.php";

$resultado = [];

if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET["search"])) {
    $busqueda = $mysql->real_escape_string($_GET["search"]);
    $buscar = "
        SELECT productos.*,
        FROM productos
        LEFT JOIN imagenes ON productos.imagen_id = imagenes.codigo
        WHERE productos.en_venta = 1 AND (
            productos.nombre LIKE '%$busqueda%' OR 
            productos.marca LIKE '%$busqueda%' OR 
            productos.modelo LIKE '%$busqueda%' OR 
            productos.descripcion LIKE '%$busqueda%'
        )
    ";
    $resultado = mysqli_query($mysql, $buscar);
}
?>
