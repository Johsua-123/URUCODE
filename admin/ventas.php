<?php
session_start();

if (!isset($_SESSION["code"])) {
    header("Location: ../index.php");
    exit();
}

$location = "ventas";
$rolesPermitidos = ["dueño", "supervisor"];
require '../api/mysql.php';

function obtenerRolUsuario($mysql, $codigoUsuario) {
    $stmt = $mysql->prepare("SELECT rol FROM usuarios WHERE codigo = ?");
    $stmt->bind_param("s", $codigoUsuario);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $usuario = $resultado->fetch_assoc();
    $stmt->close();
    return $usuario['rol'] ?? null;
}

function procesarAccion($mysql, $accion, $ordenId) {
    $query = $accion === 'completar' 
        ? "UPDATE ordenes SET estado = 'completado' WHERE codigo = ?" 
        : "DELETE FROM ordenes WHERE codigo = ?";

    $stmt = $mysql->prepare($query);
    $stmt->bind_param("i", $ordenId);
    $ejecutado = $stmt->execute();
    $stmt->close();

    return $ejecutado ? "Acción realizada con éxito." : "Error: " . $mysql->error;
}

$rolUsuario = obtenerRolUsuario($mysql, $_SESSION["code"]);
if (!$rolUsuario || !in_array($rolUsuario, $rolesPermitidos)) {
    header("Location: index.php");
    exit();
}

$mensaje = $error = null;
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['orden_id'])) {
    $ordenId = intval($_POST['orden_id']);
    if (isset($_POST['completar'])) {
        $mensaje = procesarAccion($mysql, 'completar', $ordenId);
    } elseif (isset($_POST['eliminar'])) {
        $mensaje = procesarAccion($mysql, 'eliminar', $ordenId);
    }
    header("Location: ventas.php");
    exit();
}

$stmt = $mysql->prepare("
    SELECT o.codigo, p.nombre AS producto, u.nombre AS comprador, u.email, o.direccion, 
           o.precio_unitario, o.subtotal, o.fecha_creacion, o.estado
    FROM ordenes o 
    JOIN productos p ON o.item_id = p.codigo
    JOIN usuarios u ON o.usuario_id = u.codigo
");
$stmt->execute();
$resultado = $stmt->get_result();
$ordenes = $resultado->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../public/icons/errea.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/styles/module.css">
    <link rel="stylesheet" href="assets/styles/navbar.css">
    <link rel="stylesheet" href="assets/styles/sidebar.css">
    <link rel="stylesheet" href="assets/styles/products.css">
    <title>Ventas | Errea Admin</title>
</head>
<body>
    <?php include "reusables/sidebar.php"; ?>
    <div class="container">
        <?php include "reusables/navbar.php"; ?>
        <main style="padding-left: 10px">
            <h1>Ventas</h1>
            <table class="accounts-table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Comprador</th>
                        <th>Contacto</th>
                        <th>Dirección</th>
                        <th>Monto</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ordenes as $orden): ?>
                        <tr>
                            <td><?= $orden['producto']; ?></td>
                            <td><?= $orden['comprador']; ?></td>
                            <td>
                                <p>Email: <?= $orden['email']; ?></p>
                            </td>
                            <td><?= $orden['direccion']; ?></td>
                            <td><?= $orden['precio_unitario']; ?></td>
                            <td><?= $orden['fecha_creacion']; ?></td>
                            <td><?= $orden['estado']; ?></td>
                            <td>
                                <form method="POST" action="" style="display:inline-block;">
                                    <input type="hidden" name="orden_id" value="<?= $orden['codigo']; ?>">
                                    <button type="submit" name="completar" class="btn btn-success">Marcar Completada</button>
                                </form>
                                <form method="POST" action="" style="display:inline-block;">
                                    <input type="hidden" name="orden_id" value="<?= $orden['codigo']; ?>">
                                    <button type="submit" name="eliminar" class="btn btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </div>
</body>
</html>
