

<?php 

    session_start();

    /*

    if (!isset($_SESSION["codigo"])) {
        http_response_code(401);
        exit;
    }

    */

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        http_response_code(405);
        exit;
    }

    $rol = $_POST["role"] ?? null;
    $accion = $_POST["accion"] ?? null;
    $codigo = $_POST["codigo"] ?? null;
    $fecha = date('Y-m-d H:i:s');
    $eliminado = $_POST["eliminado"] ?? false;
 
    if (empty($accion) || empty($tamaño) || empty($pagina)) {
        http_response_code(400);
        exit;
    }

    require "mysql.php";

    if ($accion == "insertar") {
        $nombre = $_POST["nombre"] ?? null;
        $imagen = $_POST["imagen"] ?? null;
        $categoria = $_POST["categoria"] ?? null;

        if (empty($nombre)) {
            http_response_code(400);
            exit;
        }

        // buscamos la categoria
        $consulta = $mysql->prepare("SELECT COUNT(*) 'total' FROM categorias WHERE nombre=?");
        $consulta->bind_param("s", $nombre);

        // se ejecuta la consulta?
        if (!$consulta->execute()) {
            http_response_code(500);
            exit;
        }

        // obtemos los resultados?
        $total = $consulta->get_result()->fetch_column()["total"];

        if ($total >= 1) {
            http_response_code(409);
            exit;
        }

        // es una subcategoria?
        if (!empty($categoria)) {
    
            // categoria principal existe?
            $consulta = $mysql->prepare("SELECT COUNT(*) 'total' FROM categorias WHERE codigo=? AND eliminado=false");
            $consulta->bind_param("i", $codigo);

            // ejecuta la consulta?
            if (!$consulta->execute()) {
                http_response_code(500);
                exit;
            }

            // obtemos los resdultados?
            $total = $consulta->get_result()->fetch_column()["total"];

            if ($total < 1) {
                http_response_code(404);
                exit;
            }

        }

        // insertamos la categoria
        $consulta = $mysql->prepare("INSERT INTO categorias (nombre, categoria_id, imagen_id, fecha_creacion, fecha_actualizacion) VALUES (?, ?, ?, ?, ?)");
        $consulta->bind_param("siiss", $nombre, $categoria, $imagen, $fecha, $fecha);

        // ejecta la consulta?
        if (!$consulta->execute() || $consulta->num_rows < 1) {
            http_response_code(500);
            exit;
        }

        exit;
    }

    if ($accion == "categoria") {

        // sistema de paginacion
        $tamaño = $_POST["tamaño"] ?? 16;
        $pagina = $_POST["pagina"] ?? 1;

        // contamos las insercciones
        $consulta = $mysql->prepare("SELECT COUNT(*) 'total' FROM categorias WHERE eliminado=?");
        $consulta->bind_param("i", $eliminado);

        // obtemos los resultados?
        $total = $consulta->get_result()->fetch_column()["total"];

        // paginamos los resultados
        $paginas = ceil($total / $tamaño);
        $ignorar = ($pagina - 1) * $tamaño;

        // obtemos las categorias
        $consulta = $mysql->prepare("SELECT * FROM categorias WHERE eliminado=? LIMIT ?, ?");
        $consulta->bind_param("iii", $eliminado, $ignorar, $tamaño);

        // ejecuta la consulta?
        if (!$consulta->execute()) {
            http_response_code(500);
            exit;
        }

        // obtemeos resultados?
        $resultado = $consulta->get_result();
        $categorias = [];

        while ($categoria = $resultado->fetch_assoc()) {
            $categorias[] = $categoria;
        }

        echo json_encode([ "total" => $total, "paginas" => $paginas, "categorias" => $categorias ]);
        exit;
    }

    if ($accion == "modificar") {

        // ingresa una categoria?
        if (empty($codigo)) {
            http_response_code(500);
            exit;
        }

        // buscamos la categoria
        $consulta = $mysql->prepare("SELECT COUNT(*) 'total' FROM categorias WHERE codigo=? AND eliminado=false");
        $consulta->bind_param("s", $codigo);

        // se ejecuta la consulta?
        if (!$consulta->execute()) {
            http_response_code(500);
            exit;
        }

        // obtemos los resultados?
        $total = $consulta->get_result()->fetch_column()["total"];

        if ($total >= 1) {
            http_response_code(409);
            exit;
        } 

        // datos a modificar
        $nombre = $_POST["nombre"] ?? null;
        $imagen = $_POST["imagen"] ?? null;
        $categoria = $_POST["categoria"] ?? null;

        if (empty($nombre)) {
            http_response_code(400);
            exit;
        }

        // icono de categoria?
        if (!empty($imagen)) {
            $consulta = $mysql->prepare("SELECT COUNT(*) 'total' FROM imagenes WHERE codigo=? AND eliminada=false");
            $consulta->bind_param("i", $codigo);

            // se ejecuta la consulta?
            if (!$consulta->execute()) {
                http_response_code(500);
                exit;
            }

            // obtemos los resultados?
            $total = $consulta->get_result()->fetch_column()["total"];

            if ($total < 1) {
                http_response_code(404);
                exit;
            }
        }
        
        if (!empty($categoria)) {
            $consulta = $mysql->prepare("SELECT COUNT(*) 'total' FROM categorias WHERE codigo=? AND eliminada=false");
            $consulta->bind_param("i", $codigo);

            // se ejecuta la consulta?
            if (!$consulta->execute()) {
                http_response_code(500);
                exit;
            }

            // obtemos los resultados?
            $total = $consulta->get_result()->fetch_column()["total"];

            if ($total < 1) {
                http_response_code(404);
                exit;
            }

        }

        $consulta = $mysql->prepare("UPDATE categorias SET nombre=?, $categoria_id=?, $imagen_id=?, fecha_actualizacion=?");
        $consulta->bind_param("siis", $nombre, $categoria, $imagen, $fecha);

        // se ejectuo la consulta?
        if (!$consulta->execute() || $consulta->num_rows < 1) {
            http_response_code(500);
            exit;
        }

        exit;
    }

    if ($accion == "eliminar") {

        // ingresa una categoria?
        if (empty($codigo)) {
            http_response_code(400);
            exit;
        }

        // buscamos la categoria
        $consulta = $mysql->prepare("SELECT COUNT(*) 'total' FROM categorias WHERE codigo=? AND eliminado=false");
        $consulta->bind_param("i", $codigo);

        // se ejecuta la consulta?
        if (!$consulta->execute()) {
            http_response_code(500);
            exit;
        }

        // obtemos los resultados?
        $total = $consulta->get_result()->fetch_column()["total"];

        if ($total < 1) {
            http_response_code(404);
            exit;
        }

        // baja de la categoria
        $consulta = $mysql->prepare("UPDATE categorias SET elimiando=true WHERE codigo=?");
        $consulta->bind_param("i", $codigo);

        // se ejectuo la consulta?
        if (!$consulta->execute() || $consulta->num_rows < 1) {
            http_response_code(500);
            exit;
        }

        // baja de subcategoria(s)
        $consulta = $mysql->prepare("UPDATE categorias SET eliminado=true, fecha_actualizacion=? WHERE categoria_id=?");
        $consulta->bind_param("si", $codigo, $fecha);

        // se ejectuo la consulta?
        if (!$consulta->execute() || $consulta->num_rows < 1) {
            http_response_code(500);
            exit;
        }

        exit;
    }
    
?>