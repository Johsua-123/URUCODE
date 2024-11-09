inventario<?php 
session_start();

if (!isset($_SESSION["code"])) {
    header("Location: ../index.php");
    exit();
}

$location = "tienda";
$servername = "localhost";
$username = "duenio";
$password = "duenio";
$dbname = "urucode";

$mysql = new mysqli($servername, $username, $password, $dbname);
if ($mysql->connect_error) {
    die("Error de conexión a la base de datos: " . $mysql->connect_error);
}

if(isset($_POST['codigo']) && is_numeric($_POST['codigo'])) { 
    $codigo_a_eliminar = $_POST['codigo']; 
    
    $update_query = " 
    UPDATE productos 
    SET en_venta = 0 
    WHERE codigo = ? 
    "; 
    
    $stmt = $mysql->prepare($update_query); 
    $stmt->bind_param("i", $codigo_a_eliminar); 
    
    if($stmt->execute()){ 
        echo "Producto con código $codigo_a_eliminar actualizado a en_venta = 0"; 
    } else { 
        echo "Error al actualizar el producto: " . $stmt->error; 
    } 
        $stmt->close(); 
    header("Location: tienda.php");
    exit();
    }

if(isset($_POST['productos']) && is_array($_POST['productos'])){
    $productos = $_POST['productos'];
    foreach ($productos as $producto) {
        list($codigo, $nombre_producto) = explode('|', $producto);

        $update_query = "
            UPDATE productos
            SET en_venta = 1
            WHERE codigo = ?
        ";

        $stmt = $mysql->prepare($update_query);
        $stmt->bind_param("i", $codigo);

        if($stmt->execute()){
            echo "Producto con código $codigo actualizado a en_venta = 1";
        } else {
            echo "Error al actualizar el producto: " . $stmt->error;
        }
        $stmt->close();
    }

    header("Location: tienda.php");
    exit();
}
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
    <script src="assets/scripts/inventario.js"></script>
    <title>Inventario | Errea Admin</title>
</head>
<body>
    <?php include "reusables/sidebar.php"; ?>
    <div class="container">
        <?php include "reusables/navbar.php"; ?>
        <main style="padding-left: 10px">
            <div class="users-title">
                <h1>Productos en venta</h1>
            </div>
            <div class="users-table">
                <div class="card">
                    <header>
                        <h2>Agregar Producto</h2>
                        <button type="button" onclick="toggleModal()">Agregar Producto</button>
                    </header>
                    <table class="accounts-table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Ícono</th>
                                <th>Stock</th>
                                <th>Precio</th>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>Categorías</th>
                                <th>Descripción</th>
                                <th>Fecha Creación</th>
                                <th>Fecha Actualización</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result = $mysql->query("
                                SELECT p.*, GROUP_CONCAT(c.nombre SEPARATOR ', ') AS categorias, img.nombre AS imagen_nombre
                                FROM productos p
                                LEFT JOIN productos_categorias pc ON p.codigo = pc.producto_id
                                LEFT JOIN categorias c ON pc.categoria_id = c.codigo
                                LEFT JOIN imagenes img ON p.imagen_id = img.codigo
                                WHERE p.en_venta = 1
                                GROUP BY p.codigo
                            ");
                            while ($producto = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                                    <td>
                                        <?php if ($producto['imagen_nombre']) { ?>
                                            <img src="<?php echo htmlspecialchars($producto['imagen_nombre']); ?>" alt="Ícono" width="50">
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
                                    <td>
                                        <form method="post" onsubmit="return confirm('¿Estás seguro que quieres eliminar este producto de la lista?');">
                                            <input type="hidden" name="codigo" value="<?php echo htmlspecialchars($producto['codigo']); ?>">
                                            <button type="submit" class="delete-button">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
    <div id="categoryModal" class="modal hidden">
        <div class="modal-content">
            <h2>Agregar Producto</h2>
            <form action="tienda.php" method="POST">
                <div>
                    <label for="productos">Productos</label>
                    <select name="productos[]" multiple>
                        <?php
                        $productos_result = $mysql->query("SELECT codigo, nombre FROM productos");
                        while ($producto = $productos_result->fetch_assoc()) {
                            echo '<option value="'.$producto['codigo'].'|'.$producto['nombre'].'">' . htmlspecialchars($producto['nombre']) . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <button type="submit">Agregar Producto</button>
                <button type="button" onclick="toggleModal()">Cerrar</button>
            </form>
        </div>
    </div>
</body>
</html>

