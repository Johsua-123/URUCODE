

<?php 

    session_start();
    $method = $_SERVER["REQUEST_METHOD"];
    $body = json_decode(file_get_contents("php://input"), true);

    require "mysql.php";

    // crear categorias
    if ($method == "POST") {

        $name = $body["name"] ?? "";
        $parent = $body["parent"] ?? "";
        $date = date('Y-m-d H:i:s');

        if (empty($body["name"])) {
            http_response_code(400);
            exit;
        }
        
        $query = mysqli_query($mysql, "SELECT COUNT(*) AS 'total' FROM categorias WHERE nombre='$name'");

        if (!$query) {
            http_response_code(500);
            exit;
        }

        $rows = [];
        while ($row = mysqli_fetch_assoc($query)) $rows[] = $row;

        if ($rows[0]["total"] > 0) {
            http_response_code(409);
            exit;
        }

        if (!empty($parent)) {
            $query = mysqli_query($mysql, "INSERT INTO categorias (nombre, padre, fecha_creacion, fecha_actualizacion) VALUES ('$name', '$parent', '$date', '$date')");
        } else {
            $query = mysqli_query($mysql, "INSERT INTO categorias (nombre, padre, fecha_creacion, fecha_actualizacion) VALUES ('$name', NULL, '$date', '$date')");
        }

        if (!$query) {
            http_response_code(500);
            exit;
        }

        exit;

    }

    // obtener categorias
    if ($method == "GET") {

        $page = $_GET["page"] ?? 1;
        $size = $_GET["size"] ?? 10;
        $child = $_GET["child"] ?? false;

        if (isset($_GET["name"])) {
            $name = $_GET["name"];
            exit;
        }

        $query = mysqli_query($mysql, "SELECT COUNT(*) AS 'total' FROM categorias");

        if (!$query) {
            http_response_code(500);
            exit;
        }

        $rows = [];
        
        while ($row = mysqli_fetch_assoc($query)) {
            $rows[] = $row;
        }
        
        $total = $rows[0]["total"];
        $offset = ($page - 1) * $size;

        if ($child) {

            exit;
        }

        $query = mysqli_query($mysql, "SELECT 
            c.codigo, 
            c.nombre, 
            c.padre, 
            c.imagen_id, 
            c.fecha_actualizacion,
            i.codigo AS 'codigo_img',
            i.nombre AS 'nombre_img',
            i.tipo AS 'tipo_img'
            FROM categorias c
            LEFT JOIN imagenes i ON c.imagen_id=i.codigo
            WHERE c.eliminado=false
            LIMIT $size 
            OFFSET $offset
        ");

        if (!$query) {
            http_response_code(500);
            exit;
        }

        $rows = [];

        while ($row = mysqli_fetch_assoc($query)) {
            $category = [
                "name" => $row["nombre"],
                "updated_at" => $row["fecha_actualizacion"]
            ];

            if (!empty($row["padre"])) {
                $category["parent"] = $row["padre"];
            }
            
            if (!empty($row["imagen_id"])) {
                $path = "public/images/" . $row["nombre_img"] . "-" . $row["codigo_img"] . $row["tipo_img"];
                unset($row["nombre_img"], $row["codigo_img"], $row["tipo_img"]);

                if (file_exists("../$path")) {
                    $category["image"] = "http://localhost/$path";
                }
            }

            $rows[] = $category;
        }
        
        echo json_encode([ "total" => $total, "filas" => $rows ]);
        exit;

    }

    http_response_code(405);

?>