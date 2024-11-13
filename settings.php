<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-DF773N72G0"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-DF773N72G0');
    </script>
    
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
            <!-- Sección de perfil -->
            <div class="profile-section">
                <div class="profile-header">
                    <h1><?php echo $_SESSION["username"] ?? ""; ?></h1>
                </div>
                <div class="profile-items">
                    <img class="<?php echo isset($_SESSION["image"]) ? "" : "hidden" ?>" src="<?php echo $_SESSION["image"] ?? ""; ?>" alt="imagen de perfil">
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

            <!-- Sección de contenido -->
            <div class="content-section">
                <div class="tab-section">
                    <div id="general" class="tab-body">
                        <h1>Perfil</h1>
                        <form id="user" method="POST" action="password.php">
                            <!-- Nombre -->
                            <div>
                                <label for="username">Nombre</label>
                                <input id="username" name="username" type="text" value="<?php echo $_SESSION["username"] ?? "" ?>">
                            </div>
                            <!-- Correo -->
                            <div>
                                <label for="email">Correo</label>
                                <input id="email" name="email" type="text" value="<?php echo $_SESSION["email"] ?? "" ?>">
                            </div>
                            <!-- Sección de cambio de contraseña -->
                            <h2>Cambiar Contraseña</h2>
                            <form id="cambiar-contraseña" method="POST" action="password.php">
                                <div>
                                    <label for="contraseña_actual">Contraseña actual</label>
                                    <input id="contraseña_actual" name="contraseña_actual" type="password" required>
                                </div>
                                <div>
                                    <label for="nueva_contraseña">Nueva contraseña</label>
                                    <input id="nueva_contraseña" name="nueva_contraseña" type="password" required>
                                </div>
                                <button type="submit">Cambiar Contraseña</button>
                            </form>
                            <!-- Fin del formulario de cambio de contraseña -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php include "reusables/footer.php" ?>
</body>
</html>
