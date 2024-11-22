<?php 
session_start();
if (!isset($_SESSION["code"])) {
    header("Location: ../index.php");
    exit();
}
require "../api/mysql.php";
// Verificar rol del usuario sino no permite entrar
$stmt = $mysql->prepare("SELECT rol FROM usuarios WHERE codigo = ?");
$stmt->bind_param("s", $_SESSION["code"]);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user || ($user["rol"] != "dueño" && $user["rol"] != "supervisor" && $user["rol"] != "admin")) {
    header("Location: index.php");
    exit();
}

//recibe el nombre de la categoría desde el formulario y la fecha actual y los asigna a variables
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nombre"])) {
    $nombre = $_POST["nombre"];
    $fecha = date("Y-m-d H:i:s");

    //inserta la nueva categoria en la bd
    $stmt = $mysql->prepare("INSERT INTO categorias (nombre, fecha_creacion, fecha_actualizacion) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nombre, $fecha, $fecha);
    $stmt->execute();
}

// obtiene todas las categorias no eliminadas de la base de datos
$stmt = $mysql->prepare("SELECT * FROM categorias WHERE eliminado = false");
$stmt->execute();
$categorias = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles/module.css">
    <link rel="stylesheet" href="assets/styles/navbar.css">
    <link rel="stylesheet" href="assets/styles/sidebar.css">
    <link rel="stylesheet" href="assets/styles/categories.css">
    <script src="assets/scripts/categories.js"></script>
    <title>Categorías</title>
</head>
<body>
    <?php include "reusables/sidebar.php"; ?>
    <div class="container">
        <?php include "reusables/navbar.php"; ?>
        <main>
            <h1>Gestión de Categorías</h1>
            <button onclick="toggleModal()">Agregar Categoría</button>
            <table>
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th>Fecha Creación</th>
                    </tr>
                </thead>
                <tbody>
                     <!-- Muestra cada categoria en una fila de la tabla -->
                    <?php while ($categoria = $categorias->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $categoria["codigo"]; ?></td>
                            <td><?php echo $categoria["nombre"]; ?></td>
                            <td><?php echo $categoria["fecha_creacion"]; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </main>
    </div>

     <!-- Modal para agregar una nueva cat -->
    <div id="categoryModal" class="modal hidden">
        <div class="modal-content">
            <h2>Agregar Categoría</h2>
            <form action="categorias.php" method="POST">
                <label>Nombre</label>
                <input type="text" name="nombre" required>
                <button type="submit">Guardar</button>
                <button type="button" onclick="toggleModal()">Cerrar</button>
            </form>
        </div>
    </div>
</body>
</html>
