<?php 

    session_start();

    if (!isset($_SESSION["code"])) {
        header("Location: ../index.php");
        exit;
    }

    $location = "inventario";
    require "../api/mysql.php";

    $categoria = $_GET["categoria"] ?? null;
    $productos = [];

    if (empty($categoria)) {

        $stmt = $mysql->prepare("SELECT 
            p.*, 
            i.codigo as 'i_codigo',
            i.nombre as 'i_nombre',
            i.extension as 'i_extension',
            c.nombre as 'c_nombre'
            FROM productos p
            LEFT JOIN imagenes i ON p.imagen_id=i.codigo
            LEFT JOIN productos_categorias pc ON pc.producto_id=p.codigo
            LEFT JOIN categorias c ON pc.categoria_id=c.codigo
            WHERE p.eliminado=false
        ");

        $stmt->execute();

        $resultado = $stmt->get_result();

        while ($producto = $resultado->fetch_assoc()) {
            
            if (!empty($producto["i_codigo"])) {
                $imagen = $producto["i_nombre"] . "-" . $producto["i_codigo"] . $producto["i_extension"];
                
                if (file_exists("../public/images/$imagen")) {
                    $producto["imagen"] = "../public/images/$imagen";
                } else {
                    $producto["imagen"] = "";
                }

            }

            unset($producto["i_codigo"], $producto["i_nombre"], $producto["i_extension"]);
            $productos[] = $producto;
        }

    } else {

        $stmt = $mysql->prepare("SELECT 
            p.*, 
            i.codigo as 'i_codigo',
            i.nombre as 'i_nombre',
            i.extension as 'i_extension',
            c.nombre as 'c_nombre'
            FROM productos p
            LEFT JOIN imagenes i ON p.imagen_id=i.codigo
            LEFT JOIN productos_categorias pc ON pc.producto_id=p.codigo
            LEFT JOIN categorias c ON pc.categoria_id=c.codigo
            WHERE p.eliminado=false AND c.codigo=?
        ");

        $stmt->bind_param("i", $categoria);
        $stmt->execute();

        $resultado = $stmt->get_result();

        while ($producto = $resultado->fetch_assoc()) {
            
            if (!empty($producto["i_codigo"])) {
                $imagen = $producto["i_nombre"] . "-" . $producto["i_codigo"] . $producto["i_extension"];
                
                if (file_exists("../public/images/$imagen")) {
                    $producto["imagen"] = "../public/images/$imagen";
                } else {
                    $producto["imagen"] = "";
                }

            }

            unset($producto["i_codigo"], $producto["i_nombre"], $producto["i_extension"]);
            $productos[] = $producto;
        }
    
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $accion = $_POST["accion"] ?? null;
        $codigo = $_GET["codigo"] ?? null;
        
        if (!empty($accion)) {

            if ($accion == "insertar") {

                $nombre = $_POST['nombre'];
                $cantidad = $_POST['cantidad'];
                $precio_venta = $_POST['precio'];
                $marca = $_POST['marca'];
                $modelo = $_POST['modelo'];
                $descripcion = $_POST['descripcion'];
                $categorias_seleccionadas = $_POST['categorias'] ?? [];
                $fecha = date("Y-m-d H:i:s");
        
                $imagen = $_FILES['icono'];
                $ruta = "../public/images/";
                $imagen_id = null;
        
                if (!empty($imagen)) {
        
                    if ($imagen['error'] == UPLOAD_ERR_OK) {
                
                        $archivo = pathinfo($imagen['name']);
                        $extension_img = strtolower($archivo["extension"]);
                        $nombre_img = $archivo["filename"];
                        
                        $stmt = $mysql->prepare("INSERT INTO imagenes (nombre, extension, fecha_creacion) VALUES (?, ?, ?)");
                        $stmt->bind_param("sss", $nombre_img, $extension_img, $fecha);
        
                        $stmt->execute();
        
                        $imagen_id = $stmt->insert_id;
        
                        move_uploaded_file($imagen["tmp_name"], "$ruta/$nombre_img-$imagen_id.$extension_img");
        
                    }
        
                }
        
                $stmt = $mysql->prepare("INSERT INTO productos (nombre, cantidad, precio_venta, marca, modelo, imagen_id, descripcion, fecha_creacion, fecha_actualizacion) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sidssisss", $nombre, $cantidad, $precio_venta, $marca, $modelo, $imagen_id, $descripcion, $fecha, $fecha);
                $stmt->execute();
                $producto_id = $stmt->insert_id;
        
                foreach ($categorias_seleccionadas as $categoria_id) {
                    $stmt_categoria = $mysql->prepare("INSERT INTO productos_categorias (producto_id, categoria_id, fecha_creacion, fecha_actualizacion) VALUES (?, ?, ?, ?)");
                    $stmt_categoria->bind_param("iiss", $producto_id, $categoria_id, $fecha, $fecha);
                    $stmt_categoria->execute();
                }
        
            } else if ($accion == "edicion") {



            } else if ($accion == "eliminar") {

            }

        }
        $stmt->close();
        $mysql->close();
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

                            $stmt = $mysql->prepare("SELECT codigo, nombre FROM categorias");
                            $stmt->execute();
                            $categorias = $stmt->get_result();
    
                            while ($fila = $categorias->fetch_assoc()) {
                                $seleccion = ($fila['codigo'] == $categoria) ? 'selected' : '';
                                echo '<option value="'. $fila['codigo'].'" '. $seleccion .'>' . $fila['nombre'] . '</option>';
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

                                <?php foreach ($productos as $producto) { ?>
                                    <tr>
                                        <td><?php echo $producto['codigo']; ?></td>
                                        <td><?php echo $producto['nombre']; ?></td>
                                        <td>
                                            <?php if (isset($producto['imagen'])) { ?>
                                                <img src="<?php echo $producto['imagen']; ?>" alt="Ícono" width="50">
                                            <?php } else { ?>
                                                No disponible
                                            <?php } ?>
                                        </td>
                                        <td><?php echo $producto['cantidad']; ?></td>
                                        <td><?php echo $producto['precio_venta']; ?></td>
                                        <td><?php echo $producto['marca']; ?></td>
                                        <td><?php echo $producto['modelo']; ?></td>
                                        <td><?php echo $producto['c_nombre']; ?></td>
                                        <td><?php echo $producto['descripcion']; ?></td>
                                        <td><?php echo $producto['fecha_creacion']; ?></td>
                                        <td><?php echo $producto['fecha_actualizacion']; ?></td>
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
                <input type="hidden" name="accion" value="insertar">
                <div>
                    <label for="nombre">Nombre del Producto</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>
                <div>
                    <label for="cantidad">Cantidad</label>
                    <input type="number" id="cantidad" name="cantidad" required>
                </div>
                <div>
                    <label for="precio">Precio Venta</label>
                    <input type="number" id="precio" name="precio" required>
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
                                echo '<option value="'. $categoria['codigo'] .'">' . $categoria['nombre'] . '</option>';
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
