<?php
session_start();

if (!isset($_SESSION["code"]) || $_SESSION["rol"] != "admin") {
    header("Location: ../index.php");
    exit();
}

if (isset($_POST['codigo']) && isset($_POST['nuevo_rol'])) {
    $codigo = $_POST['codigo'];
    $nuevo_rol = $_POST['nuevo_rol'];

    $mysql = new mysqli("localhost", "usuario", "contraseña", "urucode");

    if ($mysql->connect_error) {
        die("Conexión fallida: " . $mysql->connect_error);
    }

    $stmt = $mysql->prepare("UPDATE usuarios SET rol = ? WHERE codigo = ?");
    $stmt->bind_param("si", $nuevo_rol, $codigo);

    if ($stmt->execute()) {
        echo "Rol actualizado con éxito.";
    } else {
        echo "Error al actualizar el rol: " . $stmt->error;
    }

    $stmt->close();
    $mysql->close();

    header("Location: accounts.php");
} else {
    echo "Datos incompletos.";
}
?>
