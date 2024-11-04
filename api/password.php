<?php
session_start();
require 'mysql.php'; 

function cambiarContraseña($usuarioId, $contraseñaActual, $nuevaContraseña) {
    global $mysql;

    $stmt = $mysql->prepare("SELECT contrasena FROM usuarios WHERE id = ?");
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

    $stmt = $mysql->prepare("UPDATE usuarios SET contrasena = ? WHERE id = ?");
    $stmt->bind_param("si", $nuevoHash, $usuarioId);
    if ($stmt->execute()) {
        echo "Contraseña cambiada exitosamente.";
        return true;
    } else {
        echo "Error al cambiar la contraseña.";
        return false;
    }
}

?>