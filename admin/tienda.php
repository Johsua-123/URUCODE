<?php 

    session_start();

    if (!isset($_SESSION["code"])) {
        header("Location: ../index.php");
    }

    require "../api/mysql.php";

    $location = "tienda";

    if ($_SESSION["role"] !== "dueño" && $_SESSION["role"] !== "supervisor" && $_SESSION["role"] !== "admin" && $_SESSION["role"] !== "empleado") {
        header("Location: ../index.php");
    }

    // datos recibidos
    $fecha = date("Y-m-d H:i:s");
    $codigo = $_POST["producto"] ?? null;
    $productos = $_POST["productos"] ?? [];

    // Eliminar una producto
    if (!empty($codigo)) {

        $stmt = $mysql->prepare("UPDATE productos SET en_venta=false, fecha_actualizacion='$fecha' WHERE codigo=?");
        $stmt->bind_param("i", $codigo);

        $stmt->execute();

        header("tienda.php");

    }

    if (!empty($productos)) {

        foreach ($productos as $producto) {

            $stmt = $mysql->prepare("UPDATE productos SET en_venta=true, fecha_actualizacion='$fecha' WHERE codigo=?");
            $stmt->bind_param("i", $producto);

            $stmt->execute();

        }

        header("tienda.php");

    }

    $productos = [];

    // Consulta para obtener productos en venta y sus relaciones
    $stmt = $mysql->prepare("SELECT 
        p.*, 
        c.nombre AS 'categoria',
        i.codigo AS 'i.codigo', i.nombre AS 'i.nombre', i.extension AS 'i.extension'
        FROM productos p
        LEFT JOIN imagenes i ON p.imagen_id=i.codigo
        LEFT JOIN productos_categorias pc ON pc.producto_id=p.codigo
        LEFT JOIN categorias c ON pc.categoria_id=c.codigo
        WHERE p.en_venta=true AND p.cantidad > 0
        ORDER BY p.fecha_actualizacion
    ");

    $stmt->execute();
    $resultado = $stmt->get_result();

    while ($producto = $resultado->fetch_assoc()) {
        if (!empty($producto["i.codigo"])) {
            $imagen = "../public/images/{$producto['i.nombre']}-{$producto['i.codigo']}{$producto['i.extension']}";
            if (file_exists($imagen)) {
                $producto["imagen"] = $imagen;
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
    <script src="assets/scripts/inventario.js"></script>
    <title>Tienda | Errea Admin</title>
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
                        <button class="agregar" type="button" onclick="toggleModal()">Agregar Producto</button>
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
                            <?php foreach ($productos as $producto) { ?>
                                <tr>
                                    <td><?php echo $producto["nombre"]; ?></td>
                                    <td>
                                         <img height="50" src="<?php echo $producto["imagen"] ?? "public/images/imagen-vacia.png" ?>" alt="imagen del producto">
                                    </td>
                                    <td><?php echo $producto["cantidad"]; ?></td>
                                    <td><?php echo $producto["precio_venta"]; ?></td>
                                    <td><?php echo $producto["marca"]; ?></td>
                                    <td><?php echo $producto["modelo"]; ?></td>
                                    <td><?php echo $producto["categoria"]; ?></td>
                                    <td><?php echo $producto["descripcion"]; ?></td>
                                    <td><?php echo $producto["fecha_creacion"]; ?></td>
                                    <td><?php echo $producto["fecha_actualizacion"]; ?></td>
                                    <td>
                                        <!-- Formulario para eliminar producto -->
                                        <form method="post" onsubmit="return confirm('¿Estás seguro que quieres eliminar este producto de la lista?');">
                                            <input type="hidden" name="producto" value="<?php echo $producto["codigo"]; ?>">
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
                <!-- Envia los datos a tienda princiapl -->
                <div>
                    <label for="productos">Productos</label>
                    <select name="productos[]" multiple>
                        <?php
                        
                            $stmt= $mysql->prepare("SELECT codigo, nombre FROM productos");
                            $stmt->execute();

                            $productos = $stmt->get_result();

                            // Genera una opción <option> para cada producto obtenido
                            while ($producto = $productos->fetch_assoc()) {
                        ?>
                        <option value="<?php echo $producto["codigo"] ?? "" ?>"><?php echo $producto["nombre"]; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <button type="submit">Agregar Producto</button>
                <button type="button" onclick="toggleModal()">Cerrar</button>
            </form>
        </div>
    </div>
</body>
</html>
