<?php 
session_start();

if (!isset($_SESSION["code"])) {
    header("Location: ../index.php");
    exit();
}
$location = "inventario";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles/module.css">
    <link rel="stylesheet" href="assets/styles/navbar.css">
    <link rel="stylesheet" href="assets/styles/sidebar.css">
    <link rel="stylesheet" href="assets/styles/products.css">
    <title>Inventario | Errea Admin</title>
</head>
<body>
    <?php include "reusables/sidebar.php"; ?>
    <div class="container">
        <?php include "reusables/navbar.php"; ?>
        <main style="padding-left: 10px">
        <h1>Inventario de Productos</h1>
            <table class="accounts-table">
            <th>Nombre</th>
            <th>Categoría</th>
            <th>Ícono</th>
            <th>Stock</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Fecha Creación</th>
            <th>Fecha Actualización</th>
            <th>Acciones</th>
        </main>
    </div>
</body>
</html>
