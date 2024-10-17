
<?php 

    session_start();
    $method = $_SERVER["REQUEST_METHOD"];
    $body = json_decode(file_get_contents("php://input"));

    if ($method == "POST") {
        if (!isset($_SESSION["code"]) || !isset($_SESSION["role"])) {
            http_response_code(400);
            exit;
        }

        $name = $body["name"] ?? "";

        if (empty(trim($name))) {
            http_response_code(400);
            exit;
        }

        http_response_code(200);
        exit;
    }

    http_response_code(405);

?>