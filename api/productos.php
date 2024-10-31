
<?php 

    session_start();
    
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        http_response_code(495);
        exit;
    }

    require "mysql.php";

    $rol = $_POST["role"] ?? null;
    $accion = $_POST["accion"] ?? null;
    $codigo = $_POST["codigo"] ?? null;
    $fecha = date('Y-m-d H:i:s');
    $eliminado = $_POST["eliminado"] ?? false;

    

?>