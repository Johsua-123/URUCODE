

<?php 

    session_start();
    $method = $_SERVER["REQUEST_METHOD"];
    $body = json_decode(file_get_contents("php://input"), true);

    require "mysql.php";

    // crear categorias
    if ($method == "POST") {

        $name = $body["nombre"] ?? "";
        $parent = $body["sub-categoria"] ?? null;
        $image = $_FILES["imagen"] ?? null;
        $date = date('Y-m-d H:i:s');

        if (empty($body["nombre"])) {
            http_response_code(400);
            exit;
        }
        
        $stmt = $mysql->prepare("SELECT COUNT(*) AS 'total' FROM categorias WHERE nombre=?");
        $stmt->bind_param("s", $name);

        if (!$stmt->execute()) {
            http_response_code(500);
            exit;
        }

        $result = $stmt->get_result()->fetch_assoc();
    
        if ($result["total"] > 0) {
            http_response_code(409);
            exit;
        }
    
        $exist = true;

        if ($parent != null) {
            $stmt = $mysql->prepare("SELECT COUNT(*) AS 'total', eliminado FROM categorias WHERE codigo=?");
            $stmt->bind_param("i", $parent);

            if (!$stmt->execute()) {
                http_response_code(500);
                exit;
            }

            $result = $stmt->get_result()->fetch_assoc();

            if ($result["total"] == 0 || $result["eliminado"] == 1) {
                http_response_code(404);
                exit;
            }

            $exist = false;
            $stmt->close();

        }

        if ($exist) {
            http_response_code(404);
            exit;
        }
    
        $stmt = $mysql->prepare("INSERT INTO categorias (nombre, padre, imagen_id, fecha_creacion, fecha_actualizacion) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("siiss", $name, $parent, $image, $date, $date);

        if (!$stmt->execute()) {
            http_response_code(500);
            exit;
        }

        $stmt->close();

        exit;

    }

    // obtener categorias
    if ($method == "GET") {

        $page = $_GET["pagina"] ?? 1;
        $size = $_GET["tamaño"] ?? 10;
        $parent = $_GET["sub-categoria"] ?? "";
        $deleted = $_GET["eliminados"] ?? false;

        $stmt = $mysql->prepare("SELECT COUNT(*) AS 'total' FROM categorias WHERE eliminados=?");
        $stmt->bind_param("b", $deleted);

        if (!$stmt->execute()) {
            http_response_code(500);
            exit;
        }

        

        if (isset($_GET["categoria"])) {
            $category = $_GET["categoria"];
            exit;
        }

        $stmt = $mysql->prepare("SELECT * FROM categorias LIMIT ?, ?");
        // $stmt->bind_param("ii", 0, 0);

        exit;

    }

    if ($method == "PATCH") {
        $category = $body["categoria"] ?? "";
        
        $stmt = $mysql->prepare("SELECT COUNT(*) AS 'total' WHERE codigo=?");
        $stmt->bind_param("i", $category);

        if (!$stmt->execute()) {
            http_response_code(500);
            exit;
        }

        $result = $stmt->get_result()->fetch_assoc();
    
        if ($result["total"] < 0) {
            http_response_code(404);
            exit;
        }

        

        exit;

    }

    if ($method == "DELETE") {

        $category = $body["categoria"] ?? null;

        $stmt = $mysql->prepare("SELECT COUNT(*) AS 'total' FROM categorias WHERE codigo=? AND eliminado=false");
        $stmt->bind_param("i", $category);

        if (!$stmt->execute()) {
            http_response_code(500);
            exit;
        }

        $result = $stmt->get_result()->fetch_assoc();

        if ($result["total"] == 0) {
            http_response_code(404);
            exit;
        }

        $stmt = $mysql->prepare("UPDATE categorias SET eliminado=true WHERE codigo=?");
        $stmt->bind_param("i", $category);

        if (!$stmt->execute()) {
            http_response_code(500);
            exit;
        }

        $stmt = $mysql->prepare("UPDATE categorias SET eliminado=true WHERE padre=?");
        $stmt->bind_param("i", $category);

        if (!$stmt->execute()) {
            http_response_code(500);
            exit;
        }

        $stmt->close();

        exit;
    }

    http_response_code(405);

?>