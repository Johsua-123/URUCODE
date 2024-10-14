
<?php 

    $method = $_SERVER["REQUEST_METHOD"];

    require "mysql.php";

    if ($method == "POST") {
        if (!isset($_POST["name"]) || empty(trim($_POST["name"]))) {
            http_response_code(400);
            exit;
        }

        $name = $_POST["name"];
        $date = date('Y-m-d H:i:s');
        
        $category = exists($mysql, "categorias", [], [], ["nombre='$name'"]);
        
        if (!$category) {
            http_response_code(500);
            exit;
        }

        if ($category["total"] > 0) {
            http_response_code(409);
            exit;
        }

        $category = insert(
            $mysql, 
            "categorias", 
            ["nombre" => "'$name'", "fecha_creacion" => "'$date'", "fecha_actualizacion" => "'$date'"]
        );

        if (!$category) {
            http_response_code(500);
            exit;
        }

        http_response_code(200);
        exit;
    }

    if ($method == "GET") {
        $page = $_POST["page"] ?? 1;
        $size = $_POST["size"] ?? 25;

        echo json_encode([$_GET["name"], $_POST["name"]]);

        http_response_code(200);
        exit;
    }

    if ($method == "PATCH") {
        if (!isset($_POST["category"]) || empty(trim($_POST["category"]))) {
            http_response_code(400);
            exit;   
        }

        $category = $_POST["category"];

        $query = mysqli_query($mysql, "SELECT * FROM categorias WHERE codigo=$name");
        $results = [];

        if (!$query) {
            http_response_code(500);
            exit;
        }

        while ($result = mysqli_fetch_assoc($query)) {
            $results[] = $result;
        }

        if (empty($results)) {
            http_response_code(404);
            exit;
        }

        if (!isset($_POST["name"]) || !isset($_POST["parent"])) {
            http_response_code(400);
            exit;
        }

        $name = $_POST["name"];
        $parent = $_POST["parent"];
        $date = date('Y-m-d H:i:s');

        $query= mysqli_query($mysql, "UPDATE categorias SET nombre='$name', padre='$parent', fecha_actualizacion='$date' WHERE codigo=$category");

        if (!$query) {
            http_response_code(500);
            exit;
        }

        http_response_code(200);
        exit;
    }

    if ($method == "DELETE") {
        if (!isset($_POST["category"]) || empty(trim($_POST["category"]))) {
            http_response_code(400);
            exit;   
        }

        $category = $_POST["category"];

        $query = mysqli_query($mysql, "SELECT * FROM categorias WHERE codigo=$category");
        $results = [];

        if (!$query) {
            http_response_code(500);
            exit;
        }

        while ($result = mysqli_fetch_assoc($query)) {
            $results[] = $result;
        }

        if (empty($results)) {
            http_response_code(404);
            exit;
        }

        $date = date('Y-m-d H:i:s');

        $query = mysqli_query($mysql, "UPDATE categorias SET eliminado='true', fecha_actualizacion='$date' WHERE codigo=$category");

        if (!$query) {
            http_response_code(500);
            exit;
        }

        http_response_code(200);
        exit;
    }

    http_response_code(400);

?>