
<?php 

    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        header("Location: ../index.php");
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        http_response_code(405);
        exit;
    }

    if (!isset($_SESSION["code"])) {
        http_response_code(401);
        exit;
    }

    define("urucode", true);
    require "mysql.php";

    $accion = $_POST["accion"] ?? null;
    $codigo = $_POST["codigo"] ?? null;
    $fecha = date('Y-m-d H:i:s');
    $elimiando = $_POST["eliminado"] ?? false;

    if (empty($accion)) {
        http_response_code(400);
        exit;
    }

    if ($accion == "insertar") {
        $marca = $_POST["marca"] ?? null;
        $nombre = $_POST["nombre"] ?? null;
        $modelo = $_POST["modelo"] ?? null;
        $costo = $_POST["precio_costo"] ?? null;
        $venta = $_POST["precio_venta"] ?? null;
        $descripcion = $_POST["descripcion"] ?? null;

        if (empty($nombre)) {
            http_response_code(400);
            exit;
        }

        $stmt = $mysql->prepare("SELECT COUNT(*) 'total' FROM productos WHERE nombre=?");
        $stmt->bind_param("s", $nombre);

        if (!$stmt->execute()) {
            http_response_code(500);
            exit;
        }

        $total = $stmt->get_result()->fetch_assoc()["total"];

        if ($total >= 1) {
            http_response_code(409);
            exit;
        }

        $stmt = $mysql->prepare("INSERT INTO productos (marca, nombre, modelo, descripcion, precio_costo, precio_venta, fecha_creacion, fecha_actualizacion) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssiiss",$marca, $nombre, $modelo, $descripcion, $costo, $venta, $fecha, $fecha);

        if ($stmt->execute() || $stmt->affected_rows < 1) {
            http_response_code(500);
            exit;
        }

        exit;

    }

    if ($accion == "modificar") {
        
        if (empty($codigo)) {
            http_response_code(400);
            exit;
        }

        $marca = $_POST["marca"] ?? null;
        $nombre = $_POST["nombre"] ?? null;
        $modelo = $_POST["Modelo"] ?? null;
        $cantidad = $_POST["cantidad"] ?? null;
        $costo = $_POST["precio-costo"] ?? null;
        $venta = $_POST["precio-venta"] ?? null;
        $descripcion = $_POST["descripcion"] ?? null;

        if (empty($marca) || empty($codigo) || empty($nombre) || empty($modelo) || empty($cantidad) || empty($costo) || empty($venta) || empty($descripcion)) {
            http_response_code(400);
            exit;
        }

        $stmt->prepare("SELECT COUNT(*) 'total' FROM productos WHERE codigo=?");
        $stmt->bind_param("i", $codigo);

        if (!$stmt->execute()) {
            http_response_code(500);
            exit;
        }

        $total = $stmt->get_result()->fetch_assoc()["total"];

        if ($total < 1) {
            http_response_code(404);
            exit;
        }

        $stmt = $mysql->prepare("UPDATE productos SET marca=? nombre=?, modelo=?, cantidad=?, descripcion=?, precio_costo=?, preico_venta=?, fecha_creacion=?, fecha_actualizacion=? WHERE codigo=?");
        $stmt->bind_param("sssssiissi",$marca, $nombre, $modelo, $cantidad, $descripcion, $costo, $venta, $fecha, $fecha, $codigo);

        if (!$stmt->execute() || $stmt->affected_rows < 1) {
            http_response_code(500);
            exit;
        }

        exit;
    }

    if ($accion == "inventario") {

        $stmt = $mysql->prepare("SELECT COUNT(*) 'total' FROM productos WHERE eliminado=?");
        $stmt->bind_param("i", $elimiando);

        if (!$stmt->execute()) {
            http_response_code(500);
            exit;
        }

        

    }

    if ($accion == "eliminar") {

        if (empty($codigo)) {
            http_response_code(400);
            exit;
        }

        $stmt = $mysql->prepare("SELECT COUNT(*) 'total' FROM productos WHERE codigo=?");
        $stmt->bind_param("i", $codigo);

        if (!$stmt->execute()) {
            http_response_code(500);
            exit;
        }

        $total = $stmt->get_result()->fetch_assoc()["total"];

        if ($total < 1) {
            http_response_code(404);
            exit;
        }

        $stmt = $mysql->prepare("UPDATE productos SET eliminado=true, fecha_actualizacion=? WHERE codigo=?");
        $stmt->bind_param("si",$fecha, $codigo);

        if (!$stmt->execute() || $stmt->affected_rows < 1) {
            http_response_code(500);
            exit;
        }

        $stmt = $mysql->prepare("UPDATE productos SET eliminado=true, fecha_actualizacion=? WHERE sub_categoria=?");
        $stmt->bind_param("si",$fecha, $codigo);

        if (!$stmt->execute() || $stmt->affected_rows < 1) {
            http_response_code(500);
            exit;
        }

        exit;
    }

?>