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
        // Obtener los detalles del producto
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
        $stmt = $mysql->prepare("INSERT INTO ordenes (
            usuario_id, nombre, apellido, email, direccion, ciudad, departamento,
            telefono, codigo_producto, cantidad, metodo_pago, precio_unitario, subtotal, estado_pago, fecha_creacion, fecha_actualizacion
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pendiente', NOW(), NOW())");

        $stmt->bind_param(
            "isssssssiiiidd",
            $userId, $firstName, $lastName, $email, $address, $city, $state, $phone,
            $productCode, $quantity, $paymentMethod, $unitPrice, $subtotal
        );

        if (!$stmt->execute()) {
            throw new Exception("Error al insertar en ordenes: " . $stmt->error);
        }

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
        error_log("Error: " . $e->getMessage());
    }

    $stmt->close();
    $mysql->close();
} else {
    echo "Acceso no autorizado.";
}
