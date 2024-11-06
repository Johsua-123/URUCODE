<?php 

    session_start();
    
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        http_response_code(495);
        exit;
    }

    define("urucode", true);
    require "mysql.php";

?>