<?php
session_start();
define("URUCODE", true);
require 'mysql.php'; 

if ($mysql->connect_error) {
    die("Error de conexión: " . $mysql->connect_error);
}

$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$productos_por_pagina = 16; 
$offset = ($pagina - 1) * $productos_por_pagina;

$query = "SELECT * FROM productos WHERE en_venta=true LIMIT $productos_por_pagina OFFSET $offset";
$result = $mysql->query($query);

$productos = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }
}

foreach ($productos as &$producto) {
    $imagen_id = $producto['imagen_id'];
    $imagen_query = "SELECT nombre FROM imagenes WHERE codigo = $imagen_id LIMIT 1";
    $imagen_result = $mysql->query($imagen_query);
    
    if ($imagen_result && $imagen_row = $imagen_result->fetch_assoc()) {
        $producto['nombre_imagen'] = $imagen_row['nombre']; 
    } else {
        $producto['nombre_imagen'] = null; 
    }
}

$total_query = "SELECT COUNT(*) as total FROM productos";
$total_result = $mysql->query($total_query);
$total_productos = $total_result->fetch_assoc()['total'];
$total_paginas = ceil($total_productos / $productos_por_pagina);

if (empty($productos)) {
    echo json_encode([
        "error" => "No se encontraron productos."
    ]);
    exit;
}

echo json_encode([
    "productos" => $productos,
    "total_paginas" => $total_paginas
]);
?>
