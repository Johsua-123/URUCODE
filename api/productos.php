
<?php 

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        exit;
    }

    $script = $_GET["script"] ?? null;
    $accion = $_POST["accion"] ?? null;

    require "mysql.php";

    if (empty($accion)) {
        exit;
    }

    if ($accion == "insertar") {

        $nombre = $_POST['nombre'];
        $cantidad = $_POST['cantidad'];
        $precio = $_POST['precio'];
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
                $extension_img = "." . $archivo["extension"];
                $nombre_img = $archivo["filename"];
                
                $stmt = $mysql->prepare("INSERT INTO imagenes (nombre, extension, fecha_creacion) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $nombre_img, $extension_img, $fecha);

                $stmt->execute();

                $imagen_id = $stmt->insert_id;

                move_uploaded_file($imagen["tmp_name"], "$ruta/$nombre_img-$imagen_id$extension_img");

            }

        }

        $stmt = $mysql->prepare("INSERT INTO productos (nombre, cantidad, precio_venta, marca, modelo, imagen_id, descripcion, fecha_creacion, fecha_actualizacion) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sidssisss", $nombre, $cantidad, $precio, $marca, $modelo, $imagen_id, $descripcion, $fecha, $fecha);
        $stmt->execute();
        $producto_id = $stmt->insert_id;

        foreach ($categorias_seleccionadas as $categoria_id) {
            $stmt_categoria = $mysql->prepare("INSERT INTO productos_categorias (producto_id, categoria_id, fecha_creacion, fecha_actualizacion) VALUES (?, ?, ?, ?)");
            $stmt_categoria->bind_param("iiss", $producto_id, $categoria_id, $fecha, $fecha);
            $stmt_categoria->execute();
        }


        header("Location: $script");
        
    }

?>