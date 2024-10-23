<?php
    session_start();

// Incluir la conexión a la base de datos
include 'api/mysql.php'; 

// Recuperar los datos del usuario desde la sesión
$code = $_SESSION["code"] ?? null;

$imagePath = null;

if ($code) {
    // Consultar si el usuario tiene una imagen asociada
    $sql = "SELECT imagenes.nombe, imagenes.codigo FROM imagenes 
            INNER JOIN usuarios ON usuarios.imagen_id = imagenes.codigo 
            WHERE usuarios.codigo = ?";
    $stmt = $mysql->prepare($sql);
    $stmt->bind_param("i", $code);
    $stmt->execute();
    $stmt->bind_result($imageName, $imageCode);
    
    if ($stmt->fetch()) {
        // Si se encuentra una imagen, se obtiene la ruta
        $imagePath = "public/images/" . $imageName;
    }
    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="public/icons/logo.png" type="image/x-icon">
        <link rel="stylesheet" href="assets/styles/module.css">
        <link rel="stylesheet" href="assets/styles/navbar.css">
        <link rel="stylesheet" href="assets/styles/footer.css">
        <link rel="stylesheet" href="assets/styles/setting.css">
        <script src="assets/scripts/navbar.js"></script>
        <script src="assets/scripts/profile.js"></script>
        <title>Ajustes | Errea</title>
    </head>
    <body>
        <?php include "reusables/navbar.php" ?>
        <main>
            <div class="settings">
                <div class="profile-section">
                    <div class="profile-header">
                        <h1><?php echo $_SESSION["username"] ?? ""; ?></h1>
                        <h2><?php echo $_SESSION["code"] ?? ""; ?></h2>
                    </div>
                    <div class="profile-items">
                        <img class="<?php echo !(isset($_SESSION["code"]) && isset($_SESSION["image"])) ? "hidden" : "" ?>" src="<?php echo $_SESSION["image"] ?? ""; ?>" alt="imagen de perfil">
                        <svg class="<?php echo (isset($_SESSION["code"]) && !isset($_SESSION["image"])) ? "" : "hidden" ?>" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"></path>
                        </svg>
                    </div>
                    <div class="profile-footer">
                        <form id="image-upload" method="POST" enctype="multipart/form-data" action="./api/cargar_imagenes.php">
                            <input name="image" type="file" hidden="true" accept=".jpeg, .jpg, .png" placeholder="example.png">
                            <input name="action" type="text" hidden="true" value="profile">
                            <div>
                                <span class="hidden"></span>
                                <button type="button" onclick="document.querySelector('input[name=image]').click();">Cargar imagen</button>
                                <button type="submit">Subir</button>
                             </div>
                        </form>
                    </div>
                </div>
                <div class="content-section">
                    <div class="tab-buttons">
                        <button type="button" tab-name="general" class="tab-active">General</button>
                        <button type="button" tab-name="cart">Carrito</button>
                    </div>
                    <div class="tab-section">
                        <div id="general" class="tab-body">
                            <h1>Perfil</h1>
                            <form id="user" method="POST">
                                <div>
                                    <label for="username">Nombre</label>
                                    <input id="username" name="username" type="text" value="<?php echo $_SESSION["username"] ?? "" ?>">
                                </div>
                                <div>
                                    <label for="surname">Apellido</label>
                                    <input id="surname" name="surname" type="text" value="<?php echo $_SESSION["surname"] ?? "" ?>">
                                </div>
                                <div>
                                    <label for="location">Ciudad | País</label>
                                    <input id="location" name="location" type="text" value="<?php echo $_SESSION["location"] ?? "" ?>">
                                </div>
                                <div>
                                    <label for="address">Dirección</label>
                                    <input type="text" value="<?php echo $_SESSION["address"] ?? "" ?>">
                                </div>
                                <div>
                                    <label for="cellphone">Teléfono</label>
                                    <input id="cellphone" name="cellphone" type="text" value="<?php echo $_SESSION["cellphone"] ?? "" ?>">
                                </div>
                                <div>
                                    <label for="email">Correo</label>
                                    <input id="email" name="email" type="text" value="<?php echo $_SESSION["email"] ?? "" ?>">
                                </div>
                            </form>
                            <div>
                                <button type="button">Cambiar contraseña</button>
                            </div>
                        </div>
                        <div class="tab-body hidden" id="cart">
                            <h1>Carrito</h1>
                        </div>
                    </div>
                </div>
           </div>
        </main>
        <?php include "reusables/footer.php" ?>
    </body>
</html>
