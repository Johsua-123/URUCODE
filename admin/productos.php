<?php 
session_start();

if (!isset($_SESSION["code"])) {
    header("Location: ../index.php");
    exit;
}

$servername = "localhost";
$username = "root"; 
$password = "";
$dbname = "urucode";  // Nombre de la base de datos según el archivo SQL

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
    $categoria = $_POST['categoria'];
    $stock = $_POST['stock'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $fecha_creacion = date("Y-m-d H:i:s");
    $fecha_actualizacion = date("Y-m-d H:i:s");

    $imagen = $_FILES['icono'];
    $ruta_imagen = '';
    $imagen_id = null;
    if ($imagen['error'] == UPLOAD_ERR_OK) {
        $nombre_imagen = basename($imagen['name']);
        $ruta_imagen = "../public/images" . $nombre_imagen;
        move_uploaded_file($imagen['tmp_name'], $ruta_imagen);

        $stmt_imagen = $conn->prepare("INSERT INTO imagenes (ruta) VALUES (?)");
        $stmt_imagen->bind_param("s", $ruta_imagen);
        $stmt_imagen->execute();
        $imagen_id = $stmt_imagen->insert_id;
        $stmt_imagen->close();
    }

    if (!empty($nombre) && !empty($categoria) && !empty($stock) && !empty($marca) && !empty($modelo) && $imagen_id) {
        $stmt = $conn->prepare("INSERT INTO productos (nombre, categoria, imagen_id, stock, marca, modelo, fecha_creacion, fecha_actualizacion) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssisssss", $nombre, $categoria, $imagen_id, $stock, $marca, $modelo, $fecha_creacion, $fecha_actualizacion);

        if ($stmt->execute()) {
            echo "<p style='color: green;'>Producto agregado correctamente.</p>";
        } else {
            echo "<p style='color: red;'>Error al agregar el producto: " . $stmt->error . "</p>";
        }

        $stmt->close();
    } else {
        echo "<p style='color: red;'>Todos los campos son obligatorios y la imagen debe ser válida.</p>";
    }
}

// Obtener los productos para mostrarlos en la tabla
$result = $conn->query("SELECT * FROM productos");
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
    <script src="assets/scripts/products.js"></script>
    <title>Productos | Errea Admin</title>
</head>
<body>
    <?php include "reusables/sidebar.php"; ?>
    <div class="container">
        <?php include "reusables/navbar.php"; ?>
        <main>
            <div class="users-title">
                <h1>Inventario</h1>
            </div>
            <div class="users-table">
                <div class="card">
                    <header>
                        <h2>Productos</h2>
                        <button type="button" onclick="toggleModal()">Agregar Producto</button>
                    </header>
                    <div class="wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Categoría</th>
                                    <th>Ícono</th>
                                    <th>Stock</th>
                                    <th>Marca</th>
                                    <th>Modelo</th>
                                    <th>Fecha Creación</th>
                                    <th>Fecha Actualización</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result && $result->num_rows > 0): ?>
                                    <?php while ($row = $result->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                                            <td><?php echo htmlspecialchars($row['categoria']); ?></td>
                                            <td>
    <?php if (!empty($row['icono'])): ?>
        <img src="<?php echo $row['icono']; ?>" alt="Ícono" width="50">
    <?php else: ?>
        <span>No disponible</span>
    <?php endif; ?>
</td>
                                            <td><?php echo htmlspecialchars($row['stock']); ?></td>
                                            <td><?php echo htmlspecialchars($row['marca']); ?></td>
                                            <td><?php echo htmlspecialchars($row['modelo']); ?></td>
                                            <td><?php echo htmlspecialchars($row['fecha_creacion']); ?></td>
                                            <td><?php echo htmlspecialchars($row['fecha_actualizacion']); ?></td>
                                            <td><!-- Agregar botones de acciones aquí si es necesario --></td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr><td colspan="9">No hay productos registrados.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <div id="productModal" class="modal hidden">
        <div class="modal-content">
            <h2>Agregar Nuevo Producto</h2>
            <form action="productos.php" method="POST" enctype="multipart/form-data">
                <div>
                    <label for="nombre">Nombre del Producto</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>
                <div>
                    <label for="categoria">Categoría</label>
                    <input type="text" id="categoria" name="categoria" required>
                </div>
                <div>
                    <label for="icono">Ícono</label>
                    <input type="file" id="icono" name="icono" accept=".jpg, .jpeg, .png" required>
                </div>
                <div>
                    <label for="stock">Stock</label>
                    <input type="number" id="stock" name="stock" required>
                </div>
                <div>
                    <label for="marca">Marca</label>
                    <input type="text" id="marca" name="marca" required>
                </div>
                <div>
                    <label for="modelo">Modelo</label>
                    <input type="text" id="modelo" name="modelo" required>
                </div>
                <button type="submit">Guardar Producto</button>
                <button type="button" onclick="toggleModal()">Cerrar</button>
            </form>
        </div>
    </div>
</body>
</html>

<?php
// Cerrar conexión
$conn->close();
?>
