<?php 
    
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        exit;
    }

    if (!isset($_POST["nombre"]) || !isset($_POST["correo"]) || !isset($_POST["asunto"]) || !isset($_POST["mensaje"])) {
        exit;
    }

    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $asunto = $_POST["asunto"];
    $mensaje = $_POST["mensaje"];

    if (empty(trim($nombre)) || empty(trim($correo)) || empty(trim($asunto)) || empty(trim($mensaje))) {
        echo json_encode([ "code" => 40, "text" => "Debes completar todos los campos"]);
        exit;
    }


?>