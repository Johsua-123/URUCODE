<?php
    session_start();
    if (!isset($_SESSION["code"])) {
        header("Location: ../index.php");
        exit();
    }
    $location = "cuentas";
    require "../api/mysql.php";
$stmt = $mysql->prepare("SELECT rol FROM usuarios WHERE codigo = ?");
$stmt->bind_param("s", $_SESSION["code"]);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
if (!$user || ($user["rol"] !== "dueño" && $user["rol"] !== "supervisor")) {
    header("Location: index.php");
    exit();
}
$stmt->close();

// Obtiene todos los usuarios no eliminados y ordenados por su código
    $stmt = $mysql->prepare("SELECT * FROM usuarios WHERE eliminado=false ORDER BY codigo");
    $stmt->execute();
    $resultado = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="../public/icons/errea.png" type="image/x-icon">
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
                <?php while($usuario = $resultado->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $usuario["codigo"]; ?></td>
                    <td><?php echo $usuario["rol"]; ?></td>
                    <td><?php echo $usuario["email"]; ?></td>
                    <td><?php echo $usuario["nombre"]; ?></td>
                    <td><?php echo $usuario["apellido"]; ?></td>
                    <td><?php echo $usuario["ubicacion"]; ?></td>
                    <td><?php echo $usuario["direccion"]; ?></td>
                    <td><?php echo $usuario["telefono"]; ?></td>
                    <td><?php echo $usuario["fecha_creacion"]; ?></td>
                </tr>
                <?php endwhile; ?>
            </table>
        </main>
    </div>
</body>
</html>
