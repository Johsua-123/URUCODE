<?php 
// se ve si el usuario tiene una sesion iniciada
    session_start();
    if (!isset($_SESSION["code"])) {
        header("Location: ../index.php");
        exit;
    }
    $location = "inventario";
    require "../api/mysql.php";

    $stmt = $mysql->prepare("SELECT rol FROM usuarios WHERE codigo = ?");
    $stmt->bind_param("s", $_SESSION["code"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    if (!$user || ($user["rol"] !== "dueño" && $user["rol"] !== "supervisor" && $user["rol"] !== "admin")) {
        header("Location: index.php");
        exit();
    }
    $stmt->close();
// almacena la cat seleccionada
    $categoria = $_GET["categoria"] ?? null;
    $productos = [];

// Consulta para obtener productos y su informacion relacionada
    $consulta = "SELECT p.*, 
        c.nombre AS 'categoria',
        i.codigo AS 'i.codigo',
        i.nombre AS 'i.nombre',
        i.extension AS 'i.extension'
        FROM productos p
        LEFT JOIN imagenes i ON p.imagen_id=i.codigo
        LEFT JOIN productos_categorias pc ON pc.producto_id=p.codigo
        LEFT JOIN categorias c ON pc.categoria_id=c.codigo
        WHERE p.eliminado=false
    ";
// Si se selecciona una cat, agrega un filtro a la consulta
    if (!empty($categoria)) {
        $consulta .= " AND c.codigo=$categoria";
    }
// Prepara y ejecuta la consulta
    $stmt = $mysql->prepare($consulta);
    $stmt->execute();
    $resultado = $stmt->get_result();

    // Procesa cada producto obtenido de la base de datos
    while ($producto = $resultado->fetch_assoc()) {

        // Verifica si el producto tiene una imagen asociada
        if (!empty($producto["i.codigo"])) {
            $imagen = $producto["i.nombre"] . "-" . $producto["i.codigo"] . $producto["i.extension"];
            
            if (file_exists("../public/images/$imagen")) {
                $producto["imagen"] = "../public/images/$imagen"; // Verifica si el archivo de la imagen existe en el servidor
            }
        }

        unset($producto["i.codigo"], $producto["i.nombre"], $producto["i.extension"]);
        
        $productos[] = $producto;

    }

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
// Obtiene la lista de categorías disponibles
                            $stmt = $mysql->prepare("SELECT codigo, nombre FROM categorias");
                            $stmt->execute();
                            $categorias = $stmt->get_result();
    // Selecciona la categoría seleccionada
                            while ($fila = $categorias->fetch_assoc()) {
                                $seleccion = ($fila["codigo"] == $categoria) ? "selected" : "";
                                echo '<option value="'. $fila["codigo"].'" '. $seleccion .'>' . $fila["nombre"] . '</option>';
                            }

                            ?>
                        </select>
                    </form>
                    <div class="wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>Codigo</th>
                                    <th>Nombre</th>
                                    <th>Imagen</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
                                    <th>Marca</th>
                                    <th>Modelo</th>
                                    <th>Categorías</th>
                                    <th>Descripción</th>
                                    <th>Fecha Creación</th>
                                    <th>Fecha Actualización</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($productos as $producto) { ?>
                                    <tr>
                                        <td><?php echo $producto["codigo"]; ?></td>
                                        <td><?php echo $producto["nombre"]; ?></td>
                                        <td>
                                            <?php if (isset($producto["imagen"])) { ?>
                                                <img src="<?php echo $producto["imagen"]; ?>" alt="imagen del producto" width="50">
                                            <?php } else { ?>
                                                No disponible
                                            <?php } ?>
                                        </td>
                                        <td><?php echo $producto["cantidad"]; ?></td>
                                        <td><?php echo $producto["precio_venta"]; ?></td>
                                        <td><?php echo $producto["marca"]; ?></td>
                                        <td><?php echo $producto["modelo"]; ?></td>
                                        <td><?php echo $producto["categoria"]; ?></td>
                                        <td><?php echo $producto["descripcion"]; ?></td>
                                        <td><?php echo $producto["fecha_creacion"]; ?></td>
                                        <td><?php echo $producto["fecha_actualizacion"]; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
 <!-- Modal para agregar productos -->
    <div id="productModal" class="modal hidden">
        <div class="modal-content">
            <h2>Agregar Nuevo Producto</h2>
            <form action="../api/productos.php?script=../admin/inventario.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="accion" value="insertar">
                <div>
                    <label for="nombre">Nombre del Producto</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>
                <div>
                    <label for="cantidad">Cantidad</label>
                    <input type="number" id="cantidad" name="cantidad" value="1" required>
                </div>
                <div>
                    <label for="precio">Precio Venta</label>
                    <input type="number" id="precio" name="precio" value="0.0" required>
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
                            
                            $stmt = $mysql->prepare("SELECT codigo, nombre FROM categorias WHERE eliminado=false");
                            $stmt->execute();

                            $resultado = $stmt->get_result();
                            
                            while ($categoria = $resultado->fetch_assoc()) {
                                echo '<option value="'. $categoria["codigo"] .'">' . $categoria["nombre"] . '</option>';
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

