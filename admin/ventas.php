<?php 
session_start();

if (!isset($_SESSION["code"])) {
    header("Location: ../index.php");
    exit();
}
$location = "ventas";

require '../api/mysql.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['completar'])) {
        $orden_id = $_POST['orden_id'];

        $stmt = $mysql->prepare("UPDATE ordenes SET estado = 'completado' WHERE codigo = ?");
        $stmt->bind_param("i", $orden_id);

        if ($stmt->execute()) {
            $mensaje = "La orden ha sido marcada como completada.";
        } else {
            $error = "Error: " . $stmt->error;
        }

        $stmt->close();
    } elseif (isset($_POST['eliminar'])) {
        $orden_id = $_POST['orden_id'];

        $stmt = $mysql->prepare("DELETE FROM ordenes WHERE codigo = ?");
        $stmt->bind_param("i", $orden_id);

        if ($stmt->execute()) {
            $mensaje = "La orden ha sido eliminada.";
        } else {
            $error = "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    header("Location: ventas.php");
    exit();
}

$stmt = $mysql->prepare("SELECT o.*, p.nombre AS producto_nombre, u.nombre AS comprador_nombre, u.email AS comprador_email
                         FROM ordenes o 
                         JOIN productos p ON o.item_id = p.codigo
                         JOIN usuarios u ON o.usuario_id = u.codigo");
$stmt->execute();
$result = $stmt->get_result();
$ordenes = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
$mysql->close();
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
            <?php if (isset($mensaje)): ?>
                <div class="alert alert-success"><?php echo $mensaje; ?></div>
            <?php endif; ?>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <table class="accounts-table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Comprador</th>
                        <th>Contacto</th>
                        <th>Dirección</th>
                        <th>Monto</th>
                        <th>Total producto</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ordenes as $orden): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($orden['producto_nombre']); ?></td>
                            <td><?php echo htmlspecialchars($orden['comprador_nombre']); ?></td>
                            <td>
                                <p>Email: <?php echo htmlspecialchars($orden['comprador_email']); ?></p>
                            </td>
                            <td><?php echo htmlspecialchars($orden['direccion']); ?></td>
                            <td><?php echo htmlspecialchars($orden['precio_unitario']); ?></td>
                            <td><?php echo htmlspecialchars($orden['subtotal']); ?></td>
                            <td><?php echo htmlspecialchars($orden['fecha_creacion']); ?></td>
                            <td><?php echo htmlspecialchars($orden['estado']); ?></td>
                            <td>
                                <form method="POST" action="" style="display:inline-block;">
                                    <input type="hidden" name="orden_id" value="<?php echo $orden['codigo']; ?>">
                                    <button type="submit" name="completar" class="btn btn-success">Marcar Completada</button>
                                </form>
                                <form method="POST" action="" style="display:inline-block;">
                                    <input type="hidden" name="orden_id" value="<?php echo $orden['codigo']; ?>">
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
