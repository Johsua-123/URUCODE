
<?php 

    session_start();

    if (!isset($_SESSION["code"])) {
        exit;
    }

    if (!isset($_FILES["image"]) || !isset($_POST["action"])) {
        echo json_encode("");
        http_response_code(400);
        exit;
    }
    
    $file = $_FILES["image"];

    if ($file["type"] != "image/png" && $file["type"] != "image/jpg" && $file["type"] != "image/jpeg") {
        echo json_encode([ "text" => "Formato de imagen invalido" ]);
        http_response_code(400);
        exit;
    }
    
    //echo json_encode([$file, $file["type"]]);
    http_response_code(200);

?>