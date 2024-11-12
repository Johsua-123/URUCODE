<?php
// Conectar a la base de datos
$servername = "localhost";
$username = "duenio";
$password = "duenio";
$dbname = "urucode";

$mysql = new mysqli($servername, $username, $password, $dbname);
if ($mysql->connect_error) {
    die("Error de conexión a la base de datos: " . $mysql->connect_error);
}

// Procesar la imagen
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['icono'])) {
    $imagen = $_FILES['icono'];
    if ($imagen['error'] === UPLOAD_ERR_OK) {
        $nombre_imagen = basename($imagen['name']);
        $ruta_imagen = "../public/images/" . $nombre_imagen;
        $tipo_imagen = pathinfo($ruta_imagen, PATHINFO_EXTENSION);
        $fecha_creacion = date("Y-m-d H:i:s");
        $fecha_actualizacion = date("Y-m-d H:i:s");

        // Mover archivo a la carpeta de imágenes
        if (move_uploaded_file($imagen['tmp_name'], $ruta_imagen)) {
            // Insertar en la base de datos
            $stmt = $mysql->prepare("INSERT INTO imagenes (nombre, enlace, fecha_creacion, fecha_actualizacion) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $nombre_imagen, $ruta_imagen, $fecha_creacion, $fecha_actualizacion);
            $stmt->execute();
            $imagen_id = $stmt->insert_id;
            $stmt->close();

            // Retornar el ID de la imagen
            echo json_encode(['imagen_id' => $imagen_id]);
        } else {
            echo json_encode(['error' => 'Error al mover el archivo.']);
        }
    } else {
        echo json_encode(['error' => 'Error al cargar el archivo.']);
    }
}

$mysql->close();
?>
