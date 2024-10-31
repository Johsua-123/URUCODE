<?php 
session_start();

if (!isset($_SESSION["code"])) {
    header("Location: ../index.php");
    exit();
}

$location = "mensajes";
require "../api/mysql.php";

if ($mysql->connect_error) {
    die("Conexión fallida: " . $mysql->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_id"])) {
    $delete_id = $_POST["delete_id"];
    $delete_sql = "DELETE FROM mensajes WHERE id = ?";
    $stmt = $mysql->prepare($delete_sql);
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();
}

$sql = "SELECT id, nombre, email, mensaje, fecha FROM mensajes ORDER BY fecha DESC";
$result = $mysql->query($sql);
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
    <title>Mensajes | Errea Admin</title>
</head>
<body>
    <?php include "reusables/sidebar.php"; ?>
    <div class="container">
        <?php include "reusables/navbar.php"; ?>
        <main>
            <h1>Mensajes de Contacto</h1>
            <div class="table-container">
                <table class="messages-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Mensaje</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td><?php echo htmlspecialchars($row['mensaje']); ?></td>
                                    <td><?php echo date("d-m-Y H:i", strtotime($row['fecha'])); ?></td>
                                    <td>
                                        <form method="post" action="" onsubmit="return confirm('¿Estas seguro que queres borrar este mensaje?');">
                                            <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                                            <button type="submit" class="delete-button">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6">No hay mensajes disponibles</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>

<?php $mysql->close(); ?>
