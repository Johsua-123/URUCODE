<?php
session_start();
require 'mysql.php'; 

function cambiarContraseña($usuarioId, $contraseñaActual, $nuevaContraseña) {
    global $mysql;

    $stmt = $mysql->prepare("SELECT contrasena FROM usuarios WHERE codigo = ?");
    $stmt->bind_param("i", $usuarioId);
    $stmt->execute();
    $stmt->bind_result($contraseñaHash);
    $stmt->fetch();
    $stmt->close();

    if (!password_verify($contraseñaActual, $contraseñaHash)) {
        echo "La contraseña actual es incorrecta.";
        return false;
    }

    $nuevoHash = password_hash($nuevaContraseña, PASSWORD_DEFAULT);

    $stmt = $mysql->prepare("UPDATE usuarios SET contrasena = ? WHERE codigo = ?");
    $stmt->bind_param("si", $nuevoHash, $usuarioId);
    if ($stmt->execute()) {
        echo "Contraseña cambiada exitosamente.";
        return true;
    } else {
        echo "Error al cambiar la contraseña.";
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['contraseña_actual']) && isset($_POST['nueva_contraseña'])) {
    $usuarioId = $_SESSION["code"];  // Asumiendo que el ID del usuario está almacenado en la sesión
    $contraseñaActual = $_POST['contraseña_actual'];
    $nuevaContraseña = $_POST['nueva_contraseña'];
    
    if (cambiarContraseña($usuarioId, $contraseñaActual, $nuevaContraseña)) {
        header("Location: ajustes.php?mensaje=Contraseña cambiada exitosamente.");
        exit();
    } else {
        header("Location: ajustes.php?error=Error al cambiar la contraseña.");
        exit();
    }
} else {
    header("Location: ajustes.php?error=Datos incompletos.");
    exit();
}
?>
