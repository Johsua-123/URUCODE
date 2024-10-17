

<?php 

    session_start();
    $method = $_SERVER["REQUEST_METHOD"];
    $body = json_decode(file_get_contents("php://input"), true);

    require "mysql.php";

    // crear categorias
    if ($method == "POST") {

        if (!isset($body["name"]) || empty($body["name"])) {
            http_response_code(400);
            exit;
        }

        $name = $body["name"];
        $parent = empty($body["parent"]) ? NULL : $body["parent"];
        $rows = [];
        
        $query = mysqli_query($mysql, "SELECT COUNT(*) AS 'total' FROM categorias WHERE nombre='$name'");

        if (!$query) {
            http_response_code(500);
            exit;
        }

        $rows = [];

        while ($row = mysqli_fetch_assoc($query)) {
            $rows[] = $row;
        }

        if ($rows[0]["total"] > 0) {
            http_response_code(409);
            exit;
        }

        $stmt = $mysql->prepare("INSERT INTO categorias (nombre, padre, fecha_creacion, fecha_actualizacion) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("s", $name);
        $stmt->bind_param("i", $parent);
        $stmt->bind_param("s", $date);
        $stmt->bind_param("s", $date);

        if (!$stmt->execute()) {
            http_response_code(500);
            exit;
        }

        $stmt->close();

    }

    // obtener categorias
    if ($method == "GET") {

        $page = $_GET["page"] ?? 1;
        $size = $_GET["size"] ?? 16;

        if (isset($_GET["name"]) && !empty($_GET["name"])) {
            $name = $_GET["name"];

            $query = $mysql->prepare("SELECT ");
        }

        $response = [];

        $stmt = $mysql->prepare("SELECT COUNT(*) as 'total' FROM categorias");
        
        // verificamos ejecucion
        if (!$stmt->execute()) {
            http_response_code(500);
            exit;
        }
        
        // obtemos resultados
        $result = $stmt->get_result();

        $rows = [];
        while ($row = $result->fetch_assoc()) $rows[] = $row;

        $pages = ceil($rows[0]["total"] / $size);

        // finalizamos consulta
        $stmt->close();

        $offset = ($page - 1) * $size;
        $stmt = $mysql->prepare("SELECT codigo, nombre FROM categorias LIMIT 16 OFFSET $offset");

        if (!$stmt->execute()) {
            http_response_code(500);
            exit;
        }

        $result = $stmt->get_result();

        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        
        // print_r($rows);

        echo json_encode(["pages" => $pages, "categories" => $rows]);

        http_response_code(200);
        exit;

    }

    http_response_code(405);

?>