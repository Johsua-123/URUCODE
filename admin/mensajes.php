<?php 
session_start();
if (!isset($_SESSION["code"])) {
    header("Location: ../index.php");
    exit();
}
$roles = ["dueño", "supervisor", "admin", "empleado"];
$location = "mensajes";
require "../api/mysql.php";
$stmt = $mysql->prepare("SELECT rol FROM usuarios WHERE codigo = ?");
$stmt->bind_param("s", $_SESSION["code"]);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
if (!$user || ($user["rol"] !== "dueño" && $user["rol"] !== "supervisor" && $user["rol"] !== "admin" && $user["rol"] !== "empleado")) {
    header("Location: index.php");
    exit();
}
$stmt->close();

//cuando el botón de marcar como leído es presionado esta consulta actualiza el atributo leído a 1 para establecer ese mensaje como uno que ya se leyó
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["marcar_leido"])) {
    $mensaje_id = $_POST["mensaje_id"];
    
    $stmt = $mysql->prepare("UPDATE mensajes SET leido = 1 WHERE codigo = ?");
    $stmt->bind_param("i", $mensaje_id);
    if ($stmt->execute()) {
        $mensaje = "El mensaje ha sido marcado como leído.";
    } else {
        $error = "Error" . $stmt->error;
    }
    
    $stmt->close();
    header("Location: mensajes.php");
    exit();
}

//obtiene todos los mensajes ordenados por su fecha de creación en orden descendente
$stmt = $mysql->prepare("SELECT * FROM mensajes ORDER BY fecha_creacion DESC");
$stmt->execute();
$result = $stmt->get_result();
$mensajes = $result->fetch_all(MYSQLI_ASSOC);

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
    <script>
        function confirmDelete() {
            return confirm("¿Estas seguro que quieres marcar este mensaje como leido?");
        }
    </script>
    <title>Mensajes | Errea Admin</title>
</head>
<body>
    <?php include "reusables/sidebar.php"; ?>
    <div class="container">
        <?php include "reusables/navbar.php"; ?>
        <main style="padding-left: 10px">
            <h1>Mensajes</h1>
            <?php if (isset($mensaje)): ?>
                <div class="alert alert-success"><?php echo $mensaje; ?></div>
            <?php endif; ?>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <table class="accounts-table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Asunto</th>
                        <th>Mensaje</th>
                        <th>Fecha</th>
                        <th>Leído</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Recorre los mensajes obtenidos -->
                    <?php foreach ($mensajes as $mensaje): ?>
                        <tr>
                            <td><?php echo $mensaje["nombre"]; ?></td>
                            <td><?php echo $mensaje["email"]; ?></td>
                            <td><?php echo $mensaje["asunto"]; ?></td>
                            <td><?php echo $mensaje["mensaje"]; ?></td>
                            <td><?php echo $mensaje["fecha_creacion"]; ?></td>
                            <td><?php echo $mensaje["leido"] ? "Sí" : "No"; ?></td>
                            <td>
                                <?php if (!$mensaje["leido"]): ?>
                                    <form method="POST" action="" style="display:inline-block;" onsubmit="return confirmDelete();">
                                        <input type="hidden" name="mensaje_id" value="<?php echo $mensaje["codigo"]; ?>">
                                        <button type="submit" name="marcar_leido" class="btn btn-success">Marcar como leído</button>
                                    </form>
                                     <!--responder vía Gmail -->
                                <?php endif; ?>
                                <a href="https://mail.google.com/mail/u/0/?view=cm&fs=1&to=<?php
                                 echo $mensaje["email"];?>
                                 &su=Re: <?php echo urlencode($mensaje["asunto"]); ?>" target="_blank" class="btn btn-primary">Responder</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </div>
</body>
</html>
