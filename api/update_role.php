<?php
session_start();

if (!isset($_SESSION["code"])) {
    header("Location: ../index.php");
    exit;
}

require "../api/mysql.php";
if ($mysql->connect_error) {
    die("Conexión fallida: " . $mysql->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["codigo"], $_POST["nuevo_rol"])) {
    $codigo = $mysql->real_escape_string($_POST["codigo"]);
    $nuevo_rol = $mysql->real_escape_string($_POST["nuevo_rol"]);

    $sql = "UPDATE usuarios SET rol = '$nuevo_rol' WHERE codigo = '$codigo'";
    if ($mysql->query($sql) === TRUE) {
        header("Location: ../admin/accounts.php"); 
    } else {
        echo "Error al actualizar el rol: " . $mysql->error;
    }
}

$mysql->close();
?>
