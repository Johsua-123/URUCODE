<?php

    session_start();

    include "mysql.php"; 

    $script = $_GET["script"] ?? "../index.php";

    if (!isset($_SESSION["code"])) {
        header("Location: $script");
    }

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        header("Location: $script");
    }

    $nombre = $_POST["nombre"] ?? null;
    $apellido = $_POST["apellido"] ?? null;
    $telefono = $_POST["telefono"] ?? null;
    $ubicacion = $_POST["ubicacion"] ?? null;
    $direccion = $_POST["direccion"] ?? null;
    $fecha = date("Y-m-d H:i:s");
    
    $stmt = $mysql->prepare("UPDATE usuarios SET nombre=?, apellido=?, telefono=?, ubicacion=?, direccion=?, fecha_actualizacion=? WHERE codigo=?");
    $stmt->bind_param("ssisssi", $nombre, $apellido, $telefono, $ubicacion, $direccion, $fecha);

    $stmt->execute();

    if ($stmt->affected_rows < 1) {
        header("Location: $script");
    }

    $_SESSION["nombre"] = $nombre;
    $_SESSION["apellido"] = $apellido;
    $_SESSION["telefono"] = $telefono;
    $_SESSION["ubicacion"] = $ubicacion;
    $_SESSION["direccion"] = $direccion;

    header("Location: $script");

?>