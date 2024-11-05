<?php 

    session_start();

    if (!isset($_SESSION["code"])) {
        header("Location: ../index.php");
    }

    $location = "mensajes";

    require "../api/mysql.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["codigo"])) {
        $codigo = $_POST["codigo"];
        $stmt = $mysql->prepare("UPDATE mensajes SET leido=true WHERE codigo=?");
        $stmt->bind_param("i", $codigo);
        $stmt->execute();
    }

    $stmt = $mysql->prepare("SELECT * FROM mensajes ORDER BY fecha_creacion DESC");
    $stmt->execute();
    $result = $stmt->get_result();

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
                            <th>Codigo</th>
                            <th>Email</th>
                            <th>Nombre</th>
                            <th>Estado</th>
                            <th>Mensaje</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $row['codigo']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo $row['nombre']; ?></td>
                                    <td><?php echo $row["leido"] ? "leido" : "no leido" ?></td>
                                    <td><?php echo $row['mensaje']; ?></td>
                                    <td><?php echo date("d-m-Y H:i", strtotime($row['fecha_creacion'])); ?></td>
                                    <td>
                                        <form method="post" onsubmit="return confirm('¿Estas seguro que queres marcar como leido este mensaje?');">
                                            <input type="hidden" name="codigo" value="<?php echo $row['codigo']; ?>">
                                            <button type="submit" class="delete-button">Leido</button>
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
