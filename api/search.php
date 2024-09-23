
<?php 

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        exit;
    }

    echo json_encode([ "code" => "200", "text" => "Funcionadad aun no disponible"]);
    exit;
    
?>