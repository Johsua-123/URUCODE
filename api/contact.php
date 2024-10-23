<?php 
    
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        http_response_code(400);
        exit;
    }

    echo json_encode([ "text" => "Funcionalidad aun no disponible" ]);
    http_response_code(200);

?>