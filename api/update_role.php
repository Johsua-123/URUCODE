<?php
session_start();

// Verificar si el usuario tiene permisos para cambiar roles (opcional)
if (!isset($_SESSION["code"]) || $_SESSION["rol"] != "admin") {
    header("Location: ../index.php");
    exit();
}

// Verificar los datos recibidos
if (isset($_POST['codigo']) && isset($_POST['nuevo_rol'])) {
    $codigo = $_POST['codigo'];
    $nuevo_rol = $_POST['nuevo_rol'];

    // Conexión a la base de datos
    $mysql = new mysqli("localhost", "usuario", "contraseña", "urucode");

    if ($mysql->connect_error) {
        die("Conexión fallida: " . $mysql->connect_error);
    }

    // Preparar la consulta para actualizar el rol
    $stmt = $mysql->prepare("UPDATE usuarios SET rol = ? WHERE codigo = ?");
    $stmt->bind_param("si", $nuevo_rol, $codigo);

    if ($stmt->execute()) {
        echo "Rol actualizado con éxito.";
    } else {
        echo "Error al actualizar el rol: " . $stmt->error;
    }

    $stmt->close();
    $mysql->close();

    // Redirigir de nuevo a la página de cuentas
    header("Location: accounts.php");
} else {
    echo "Datos incompletos.";
}
?>
