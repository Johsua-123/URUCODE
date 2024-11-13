<?php
session_start();

if (!isset($_SESSION["code"])) {
    header("Location: ../index.php");
    exit();
}

$location = "cuentas";

define("URUCODE", true);
require "../api/mysql.php";

$stmt = $mysql->prepare("SELECT * FROM usuarios ORDER BY nombre");
$stmt->execute();
$resultado = $stmt->get_result();
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
    <title>Cuentas | Errea Admin</title>
</head>
<body>
    <?php include "reusables/sidebar.php"; ?>
    <div class="container">
        <?php include "reusables/navbar.php"; ?>
        <main style="padding-left: 10px">
            <h1>Listado de Cuentas</h1>
            <table class="accounts-table">
                <tr>
                    <th>ID</th>
                    <th>Rol</th>
                    <th>Email</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Ubicación</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                    <th>Fecha de Creación</th>
                </tr>
                <?php while($fila = $resultado->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($fila["codigo"]); ?></td>
                    <td><?php echo htmlspecialchars($fila["rol"]); ?></td>
                    <td><?php echo htmlspecialchars($fila["email"]); ?></td>
                    <td><?php echo htmlspecialchars($fila["nombre"]); ?></td>
                    <td><?php echo htmlspecialchars($fila["apellido"]); ?></td>
                    <td><?php echo htmlspecialchars($fila["ubicacion"]); ?></td>
                    <td><?php echo htmlspecialchars($fila["direccion"]); ?></td>
                    <td><?php echo htmlspecialchars($fila["telefono"]); ?></td>
                    <td><?php echo htmlspecialchars($fila["fecha_creacion"]); ?></td>
                </tr>
                <?php endwhile; ?>
            </table>
        </main>
    </div>
</body>
</html>
