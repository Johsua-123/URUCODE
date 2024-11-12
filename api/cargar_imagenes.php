<?php
session_start();

include 'mysql.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"])) {
    $code = $_SESSION["code"];
    $targetDir = "../public/images/";
    $imageType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);

    $verifyImg = getimagesize($_FILES["image"]["tmp_name"]);
    if ($verifyImg === false) {
        die("El archivo no es una imagen válida.");
    }

    $format = array("jpg", "png", "jpeg");
    if (!in_array($imageType, $format)) {
        die("Solo se permiten los formatos JPG, JPEG y PNG.");
    }

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        $insertImage = "INSERT INTO imagenes (nombre, codigo, fecha_creacion, fecha_actualizacion) VALUES (?, ?, NOW(), NOW())";
        $stmt = $mysql->prepare($insertImage);
        $imageCode = uniqid(); 
        $stmt->bind_param("ss", $targetFile, $imageCode);
        
        if ($stmt->execute()) {
            $imageId = $mysql->insert_id;

            $updateUser = "UPDATE usuarios SET imagen_id = ? WHERE codigo = ?";
            $stmtUpdate = $mysql->prepare($updateUser);
            $stmtUpdate->bind_param("ii", $imageId, $code);

            $_SESSION["image"] = "public/images/" . basename($_FILES["image"]["name"]);
            header("Location: ../settings.php");

            if ($stmtUpdate->execute()) {
                $_SESSION["image"] = $targetFile; 
                header("Location: ../settings.php"); 
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
