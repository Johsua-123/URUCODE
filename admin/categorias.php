<?php 
    
    session_start();

    if (!isset($_SESSION["code"])) {
        header("Location: ../index.php");
        exit;
    }

    $location = "categorias";

$servername = "localhost";
$username = "duenio";
$password = "duenio";
$dbname = "urucode";

$mysql = new mysqli($servername, $username, $password, $dbname);
if ($mysql->connect_error) {
    die("Error de conexión a la base de datos: " . $mysql->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
    $fecha_creacion = date("Y-m-d H:i:s");
    $fecha_actualizacion = date("Y-m-d H:i:s");

    // Inserta la categoría principal
    $stmt = $mysql->prepare("INSERT INTO categorias (nombre, fecha_creacion, fecha_actualizacion) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nombre, $fecha_creacion, $fecha_actualizacion);
    $stmt->execute();
    $stmt->close();
}

$result = $mysql->query("SELECT * FROM categorias");
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
    <title>Categorías | Errea Admin</title>
</head>
<body>
    <?php include "reusables/sidebar.php"; ?>
    <div class="container">
        <?php include "reusables/navbar.php"; ?>
        <main>
            <div class="users-title">
                <h1>Gestión de Categorías</h1>
            </div>
            <div class="users-table">
                <div class="card">
                    <header>
                        <h2>Categorías</h2>
                        <button type="button" onclick="toggleModal()">Agregar Categoría</button>
                    </header>
                    <div class="wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($categoria = $result->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($categoria['nombre']); ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <div id="categoryModal" class="modal hidden">
        <div class="modal-content">
            <h2>Agregar Nueva Categoría</h2>
            <form action="categorias.php" method="POST">
                <div>
                    <label for="nombre">Nombre de la Categoría</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>
                <button type="submit">Guardar Categoría</button>
                <button type="button" onclick="toggleModal()">Cerrar</button>
            </form>
        </div>
    </div>
</body>
</html>

<?php $mysql->close(); ?>
