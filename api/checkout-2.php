<?php
session_start();
require "mysql.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario_id = $_SESSION["code"]; 
    $item_id = $_POST["codigoProducto"];
    $cantidad = $_POST["cantidadProducto"];
    $precio_unitario = $_POST["precioProducto"];
    $subtotal = $cantidad * $precio_unitario;
    $estado = "Pendiente"; 
    $direccion = $_POST["direccionCliente"];
    $item_tipo = $_POST["tipoItem"]; 

    if ($item_tipo == "productos") {
        $stmt = $mysql->prepare("SELECT COUNT(*) FROM productos WHERE codigo = ?");
    } else if ($item_tipo == "Servicio") {
        $stmt = $mysql->prepare("SELECT COUNT(*) FROM servicios WHERE codigo = ?");
    } else {
        echo "Tipo de ítem no válido.";
        exit;
    }

    $stmt->bind_param("i", $item_id);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count == 0) {
        echo "El item_id no existe en la tabla correspondiente.";
        exit;
    }

    $stmt = $mysql->prepare("INSERT INTO ordenes (usuario_id, item_id, cantidad, precio_unitario, subtotal, estado, fecha_creacion, fecha_actualizacion, direccion, item_tipo) VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW(), ?, ?)");
    $stmt->bind_param("iiiddsss", $usuario_id, $item_id, $cantidad, $precio_unitario, $subtotal, $estado, $direccion, $item_tipo);

    if($item_tipo == "productos"){
        if ($stmt->execute()) {
        header("Location: ../tienda.php");
    } else {
        echo "Error: " . $stmt->error;
    }
    }

    

    $stmt->close();
    $mysql->close();
} else {
    echo "Método de solicitud no válido.";
}
?>
