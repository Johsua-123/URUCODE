<?php
session_start();

// Incluir la conexión a la base de datos
include 'mysql.php'; // Asegúrate de que este archivo contenga la conexión a la BD

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"])) {
    // Obtener el ID del usuario desde la sesión
    $code = $_SESSION["code"]; // El ID del usuario debe estar almacenado en la sesión
    $targetDir = "../public/images/"; // Directorio donde se guardan las imágenes
    $imageType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);

    // Validar si el archivo es una imagen
    $verifyImg = getimagesize($_FILES["image"]["tmp_name"]);
    if ($verifyImg === false) {
        die("El archivo no es una imagen válida.");
    }

    // Verificar que el formato sea permitido
    $format = array("jpg", "png", "jpeg");
    if (!in_array($imageType, $format)) {
        die("Solo se permiten los formatos JPG, JPEG y PNG.");
    }

    // Mover el archivo al servidor
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        // Insertar la imagen en la tabla imagenes
        $insertImage = "INSERT INTO imagenes (nombe, codigo, fecha_creacion, fecha_actualizacion) VALUES (?, ?, NOW(), NOW())";
        $stmt = $mysql->prepare($insertImage);
        $imageCode = uniqid(); // Genera un código único para la imagen
        $stmt->bind_param("ss", $targetFile, $imageCode);
        
        if ($stmt->execute()) {
            // Obtener el ID de la imagen recién insertada
            $imageId = $mysql->insert_id;

            // Actualizar el campo imagen_id en la tabla usuarios
            $updateUser = "UPDATE usuarios SET imagen_id = ? WHERE codigo = ?";
            $stmtUpdate = $mysql->prepare($updateUser);
            $stmtUpdate->bind_param("ii", $imageId, $code);

            if ($stmtUpdate->execute()) {
                $_SESSION["image"] = $targetFile; // Actualizar la imagen en la sesión
                header("Location: ../settings.php"); // Redirigir a la página de ajustes
            } else {
                echo "Error al actualizar la imagen en el perfil del usuario.";
            }
        } else {
            echo "Error al guardar la imagen en la base de datos.";
        }
    } else {
        echo "Hubo un error al subir la imagen.";
    }
}
?>
