<?php 

    session_start();
    
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        http_response_code(495);
        exit;
    }

    $rol = $_POST["role"] ?? null;
    $accion = $_POST["accion"] ?? null;
    $codigo = $_POST["codigo"] ?? null;
    $fecha = date('Y-m-d H:i:s');
    $eliminado = $_POST["eliminado"] ?? false;

    if (empty($accion)) {
        http_response_code(400);
        exit;
    }

    require "mysql.php";

    if ($accion == "insertar") {
        $nombre = $_POST["nombre"] ?? "";
        $stock = $_POST["stock"] ?? 0;
        $marca = $_POST["marca"] ?? null;
        $precio = $_POST["precio"] ?? 0.0;
        $modelo = $_POST["modelo"] ?? null;
        $imagen = $_POST["imagen"] ?? null;
        $descripcion = $_POST["descripcion"] ?? null;

        if (empty($nombre)) {
            http_response_code(400);
            exit;
        }

        // buscamos la categoria
        $consulta = $mysql->prepare("SELECT COUNT(*) 'total' FROM categorias WHERE nombre=?");
        $consulta->bind_param("s", $nombre);

        // se ejecuta la consulta?
        if (!$consulta->execute()) {
            http_response_code(500);
            exit;
        }

        // obtemos los resultados?
        $total = $consulta->get_result()->fetch_assoc()["total"];

        if ($total >= 1) {
            http_response_code(409);
            exit;
        }

        // tiene un icono?
        if (empty($imagen)) {
            $consulta = $mysql->prepare("SELECT COUNT(*) 'total' FROM imagenes WHERE codigo=? AND eliminado=false");
            $consulta->bind_param("i", $imagen);

            if (!$consulta->execute()) {
                http_response_code(500);
                exit;
            }
        
            $total = $consulta->get_result()->fetch_assoc()["total"];

            if ($total < 1) {
                $imagen = null;
            }

        }
        
        $consulta = $mysql->prepare("INSERT INTO productos (nombre, stock, marca, modelo, precio, imagen_id, descripcion, fecha_creacion, fecha_actualizacion) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $consulta->bind_param("sissiisss", $nombre, $stock, $marca, $modelo, $precio, $imagen, $descripcion, $fecha, $fecha);

        if (!$consulta->execute() || $consulta->affected_rows < 1) {
            http_response_code(500);
            exit;
        }

        exit;
    }

?>