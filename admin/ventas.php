<?php 
session_start();

if (!isset($_SESSION["code"])) {
    header("Location: ../index.php");
    exit();
}
$location = "ventas";
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
        <h1>Ventas</h1>
            <table class="accounts-table">
            <th>Producto</th>
            <th>Comprador</th>
            <th>Contacto</th>
            <th>Direccion</th>
            <th>Monto</th>
            <th>Total producto</th>
            <th>Fecha</th>
            <th>Acciones</th>
        </main>
    </div>
</body>
</html>
