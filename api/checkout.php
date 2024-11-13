<?php
session_start();

require 'mysql.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $phone = $_POST['phone'];
    $productCode = $_POST['productCode']; 
    $quantity = 1; // Cantidad por defecto
    $paymentMethod = $_POST['paymentMethod']; 
    $userId = $_SESSION['user_id']; // Asume que el usuario ha iniciado sesión y su ID está en la sesión

    $mysql->begin_transaction();

    try {
        $stmt = $mysql->prepare("SELECT nombre, precio_venta FROM productos WHERE codigo = ?");
        $stmt->bind_param("i", $productCode);
        $stmt->execute();
        $result = $stmt->get_result();
        $producto = $result->fetch_assoc();

        if (!$producto) {
            throw new Exception("Producto no encontrado");
        }

        $productName = $producto['nombre'];
        $unitPrice = $producto['precio_venta'];
        $subtotal = $unitPrice * $quantity;

        // Insertar en la tabla ordenes
        $stmt = $mysql->prepare("INSERT INTO ordenes (subtotal, usuario_id, fecha_creacion, fecha_actualizacion) VALUES (?, ?, NOW(), NOW())");
        $stmt->bind_param("di", $subtotal, $userId);
        $stmt->execute();
        $orderId = $mysql->insert_id;

        // Insertar en la tabla ordenes_detalles
        $stmt = $mysql->prepare("INSERT INTO ordenes_detalles (precio, item_id, cantidad, orden_id, subtotal, item_tipo, fecha_creacion, fecha_actualizacion) VALUES (?, ?, ?, ?, ?, 'producto', NOW(), NOW())");
        $stmt->bind_param("diiii", $unitPrice, $productCode, $quantity, $orderId, $subtotal);
        $stmt->execute();

        // Insertar en la tabla pagos
        $stmt = $mysql->prepare("INSERT INTO pagos (estado, metodo, orden_id, usuario_id, fecha_creacion, fecha_actualizacion) VALUES ('pendiente', ?, ?, ?, NOW(), NOW())");
        $stmt->bind_param("sii", $paymentMethod, $orderId, $userId);
        $stmt->execute();

        $mysql->commit();

        echo "<script>
            Swal.fire({
                title: '¡Gracias por tu compra!',
                text: 'Tu pedido ha sido realizado con éxito.',
                icon: 'success',
                confirmButtonText: 'Cerrar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'index.php';
                }
            });
        </script>";
    } catch (Exception $e) {
        $mysql->rollback();
        echo "<script>
            Swal.fire({
                title: 'Error',
                text: 'Hubo un problema al procesar tu pedido. Por favor, intenta de nuevo.',
                icon: 'error',
                confirmButtonText: 'Cerrar'
            });
        </script>";
    }

    $stmt->close();
    $mysql->close();
} else {
    echo "Acceso no autorizado.";
}
?>
