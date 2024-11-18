<?php 
    
    session_start();

    if (!isset($_SESSION["code"])) {
        header("Location: ../index.php");
    }

    $location = "categorias";

    require "../api/mysql.php";

    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["nombre"])) {
        $nombre = $_POST['nombre'];
        $fecha = date("Y-m-d H:i:s");

        $stmt = $mysql->prepare("INSERT INTO categorias (nombre, fecha_creacion, fecha_actualizacion) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nombre, $fecha, $fecha);
        $stmt->execute();
    }

    $stmt = $mysql->prepare("SELECT * FROM categorias WHERE eliminado=false");
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
                                        <th>Codigo</th>
                                        <th>Nombre</th>
                                        <th>Fecha Creacion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($categoria = $resultado->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?php echo $categoria["codigo"]; ?></td>
                                            <td><?php echo $categoria["nombre"]; ?></td>
                                            <td><?php echo $categoria["fecha_creacion"]; ?></td>
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
