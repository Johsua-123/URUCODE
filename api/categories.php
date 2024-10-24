

<?php 

    session_start();
    $method = $_SERVER["REQUEST_METHOD"];
    $body = json_decode(file_get_contents("php://input"), true);

    require "mysql.php";

    // crear categorias
    if ($method == "POST") {

        $name = $body["nombre"] ?? "";
        $parent = !isset($body["sub-categoria"]) || empty($body["sub-categoria"]) ? null : $body["sub-categoria"];
        $image = !isset($body["imagen"]) || empty($body["imagen"]) ? null : $body["imagen"];
        $date = date('Y-m-d H:i:s');

        if (empty($body["nombre"])) {
            http_response_code(400);
            exit;
        }
        
        $stmt = $mysql->prepare("SELECT codigo, COUNT(*) 'total' FROM categorias WHERE nombre=?");
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

        if ($parent != null) {
            if ($parent == $result["codigo"]) {
                http_response_code(409);
                exit;
            }

            $stmt = $mysql->prepare("SELECT COUNT(*) 'total' FROM categorias WHERE codigo=? AND eliminado=false");
            $stmt->bind_param("i", $parent);

            if (!$stmt->execute()) {
                http_response_code(500);
                exit;
            }

            $result = $stmt->get_result()->fetch_assoc();

            if ($result["total"] == 0) {
                http_response_code(404);
                exit;
            }

            $stmt->close();
        }
        
        if ($image != null) {
            $stmt = $mysql->prepare("SELECT COUNT(*) 'total' FROM imagenes WHERE codigo=?");
            $stmt->bind_param("i", $image);

            if (!$stmt->execute()) {
                http_response_code(500);
                exit;
            }

            if ($result["total"] == 0) {
                http_response_code(404);
                exit;
            }

            $stmt->close();
        }

        $stmt = $mysql->prepare("INSERT INTO categorias (nombre, padre, imagen_id, fecha_creacion, fecha_actualizacion) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("siiss", $name, $parent, $image, $date, $date);

        if (!$stmt->execute()) {
            http_response_code(500);
            exit;
        }

        if ($stmt->affected_rows < 1) {
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
        $deleted = $_GET["eliminados"] ?? false;
        $parent = $_GET["sub-categoria"] ?? false;

        $stmt = $mysql->prepare("SELECT COUNT(*) 'total' FROM categorias WHERE eliminado=?");
        $stmt->bind_param("i", $deleted);

        if (!$stmt->execute()) {
            http_response_code(500);
            exit;
        }

        $total = $stmt->get_result()->fetch_assoc()["total"];

        if ($total == 0) {
            http_response_code(404);
            exit;
        }
        
        $pages = ceil($total / $size);
        $skip = ($page - 1) * $size;        

        $stmt = $mysql->prepare("SELECT * FROM categorias WHERE eliminado=? LIMIT ?, ?");
        $stmt->bind_param("iii", $deleted, $skip, $size);

        if (!$stmt->execute()) {
            http_response_code(500);
            exit;
        }

        $result = $stmt->get_result();
        $rows = [];

        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        echo json_encode([ "total" => $total, "paginas" => $pages, "categorias" => $rows ]);
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

        $stmt->close();
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