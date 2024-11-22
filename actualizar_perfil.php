<?php
session_start();
include 'api/mysql.php'; 
if (!isset($_SESSION['code'])) {
    echo "Usuario no autenticadoo";
    exit;
}
$code = $_SESSION['code'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nombre = $_POST['nombre'] ?? '';
    $apellido = $_POST['apellido'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $ubicacion = $_POST['ubicacion'] ?? '';
    $direccion = $_POST['direccion'] ?? '';

    $mysql = new mysqli("127.0.0.1", "duenio", "duenio", "urucode");
    
    $sql = "UPDATE usuarios SET 
            nombre = '$nombre', 
            apellido = '$apellido', 
            telefono = '$telefono', 
            ubicacion = '$ubicacion', 
            direccion = '$direccion', 
            fecha_actualizacion = NOW() 
            WHERE codigo = '$code'";

    if ($mysql->query($sql) === TRUE) {
        echo "Perfil actualizado exitosamente.";
        
        $_SESSION['nombre'] = $nombre;
        $_SESSION['apellido'] = $apellido;
        $_SESSION['telefono'] = $telefono;
        $_SESSION['ubicacion'] = $ubicacion;
        $_SESSION['direccion'] = $direccion;

        header("Location: ajustes.php?mensaje=actualizado");
        exit;
    } else {
        echo "Error al actualizar el perfil: " . $conexion->error;
    }

} else {
    echo "El formulario no fue enviado correctamente.";
}