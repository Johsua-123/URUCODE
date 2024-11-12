<?php 
session_start();

if (!isset($_SESSION["code"])) {
    header("Location: ../index.php");
    exit;
}

$location = "inventario";

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
    $cantidad = $_POST['cantidad'];
    $precio_venta = $_POST['precio_venta'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $descripcion = $_POST['descripcion'];
    $categorias_seleccionadas = $_POST['categorias'] ?? [];
    $fecha_creacion = date("Y-m-d H:i:s");
    $fecha_actualizacion = date("Y-m-d H:i:s");

    $imagen = $_FILES['icono'];
    $imagen_id = null;
    if ($imagen['error'] == UPLOAD_ERR_OK) {
        $nombre_imagen = basename($imagen['name']);
        $ruta_imagen = "../public/images/" . $nombre_imagen;
        move_uploaded_file($imagen['tmp_name'], $ruta_imagen);

        $stmt_imagen = $mysql->prepare("INSERT INTO imagenes (nombre, enlace, fecha_creacion, fecha_actualizacion) VALUES (?, ?, ?, ?)");
        $tipo = pathinfo($ruta_imagen, PATHINFO_EXTENSION);
        $stmt_imagen->bind_param("ssss", $ruta_imagen, $tipo, $fecha_creacion, $fecha_actualizacion);
        $stmt_imagen->execute();
        $imagen_id = $stmt_imagen->insert_id;
        $stmt_imagen->close();
    }

    $stmt = $mysql->prepare("INSERT INTO productos (nombre, cantidad, precio_venta, marca, modelo, imagen_id, descripcion, fecha_creacion, fecha_actualizacion) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sidssisss", $nombre, $cantidad, $precio_venta, $marca, $modelo, $imagen_id, $descripcion, $fecha_creacion, $fecha_actualizacion);
    $stmt->execute();
    $producto_id = $stmt->insert_id;
    $stmt->close();

    foreach ($categorias_seleccionadas as $categoria_id) {
        $stmt_categoria = $mysql->prepare("INSERT INTO productos_categorias (producto_id, categoria_id, fecha_creacion, fecha_actualizacion) VALUES (?, ?, ?, ?)");
        $stmt_categoria->bind_param("iiss", $producto_id, $categoria_id, $fecha_creacion, $fecha_actualizacion);
        $stmt_categoria->execute();
        $stmt_categoria->close();
    }
}

$selected_categoria_id = $_GET['categoria'] ?? null;

$query = "
    SELECT p.codigo, p.nombre, p.cantidad, p.precio_venta, p.marca, p.modelo, p.descripcion, p.fecha_creacion, p.fecha_actualizacion, i.enlace AS imagen_enlace, GROUP_CONCAT(c.nombre SEPARATOR ', ') AS categorias
    FROM productos p
    LEFT JOIN imagenes i ON p.imagen_id = i.codigo
    LEFT JOIN productos_categorias pc ON p.codigo = pc.producto_id
    LEFT JOIN categorias c ON pc.categoria_id = c.codigo";

if ($selected_categoria_id) {
    $query .= " WHERE pc.categoria_id = " . intval($selected_categoria_id);
}

$query .= " GROUP BY p.codigo";
$result = $mysql->query($query);
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
                <h1>Inventario de productos</h1>
            </div>
            <div class="users-table">
                <div class="card">
                    <header>
                        <h2>Productos</h2>
                        <button type="button" onclick="toggleModal()">Agregar Producto</button>
                    </header>
                    <form method="GET" action="inventario.php">
                        <label for="categoria">Filtrar por Categoría:</label>
                        <select name="categoria" id="categoria" onchange="this.form.submit()">
                            <option value="">Todas</option>
                            <?php
                            $categorias_result = $mysql->query("SELECT codigo, nombre FROM categorias");
                            while ($categoria = $categorias_result->fetch_assoc()) {
                                $selected = ($categoria['codigo'] == $selected_categoria_id) ? 'selected' : '';
                                echo '<option value="'.$categoria['codigo'].'" '.$selected.'>' . htmlspecialchars($categoria['nombre']) . '</option>';
                            }
                            ?>
                        </select>
                    </form>
                    <div class="wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Ícono</th>
                                    <th>Cantidad</th>
                                    <th>Precio Venta</th>
                                    <th>Marca</th>
                                    <th>Modelo</th>
                                    <th>Categorías</th>
                                    <th>Descripción</th>
                                    <th>Fecha Creación</th>
                                    <th>Fecha Actualización</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($producto = $result->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                                        <td>
                                            <?php if ($producto['imagen_enlace']) { ?>
                                                <img src="<?php echo htmlspecialchars($producto['imagen_enlace']); ?>" alt="Ícono" width="50">
                                            <?php } else { ?>
                                                No disponible
                                            <?php } ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($producto['cantidad']); ?></td>
                                        <td><?php echo htmlspecialchars($producto['precio_venta']); ?></td>
                                        <td><?php echo htmlspecialchars($producto['marca']); ?></td>
                                        <td><?php echo htmlspecialchars($producto['modelo']); ?></td>
                                        <td><?php echo htmlspecialchars($producto['categorias']); ?></td>
                                        <td><?php echo htmlspecialchars($producto['descripcion']); ?></td>
                                        <td><?php echo htmlspecialchars($producto['fecha_creacion']); ?></td>
                                        <td><?php echo htmlspecialchars($producto['fecha_actualizacion']); ?></td>
                                    </tr>
                                <?php } ?>
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
            <form action="inventario.php" method="POST" enctype="multipart/form-data">
                <div>
                    <label for="nombre">Nombre del Producto</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>
                <div>
                    <label for="cantidad">Cantidad</label>
                    <input type="number" id="cantidad" name="cantidad" required>
                </div>
                <div>
                    <label for="precio_venta">Precio Venta</label>
                    <input type="number" step="0.01" id="precio_venta" name="precio_venta" required>
                </div>
                <div>
                    <label for="marca">Marca</label>
                    <input type="text" id="marca" name="marca">
                </div>
                <div>
                    <label for="modelo">Modelo</label>
                    <input type="text" id="modelo" name="modelo">
                </div>
                <div>
                    <label for="descripcion">Descripción</label>
                    <textarea id="descripcion" name="descripcion"></textarea>
                </div>
                <div>
                    <label for="icono">Ícono</label>
                    <input type="file" id="icono" name="icono" accept=".jpg, .jpeg, .png, .webp" required>
                </div>
                <div>
                    <label for="categorias">Categorías</label>
                    <select name="categorias[]" multiple>
                        <?php
                        $categorias_result = $mysql->query("SELECT codigo, nombre FROM categorias");
                        while ($categoria = $categorias_result->fetch_assoc()) {
                            echo '<option value="'.$categoria['codigo'].'">' . htmlspecialchars($categoria['nombre']) . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <button type="submit">Guardar Producto</button>
                <button type="button" onclick="toggleModal()">Cerrar</button>
            </form>
        </div>
    </div>
</body>
</html>

<?php $mysql->close(); ?>
