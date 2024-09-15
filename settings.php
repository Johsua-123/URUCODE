<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                        <form id="image-upload" method="POST">
                            <input name="image" type="file" hidden="true" accept=".jpeg, .jpg, .png" placeholder="example.png">
                            <input name="action" type="text" hidden="true" value="profile">
                            <div>
                                <span class="hidden"></span>
                                <button type="button">Cargar imagen</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="content-section">
                    <div class="tab-buttons">
                        <button type="button" tab-name="general">General</button>
                        <button type="button" tab-name="cart">Carrito</button>
                    </div>
                    <div class="tab-section">
                        <div id="general">
                            <h1>Perfil</h1>
                        </div>
                        <div class="hidden" id="cart">
                            <h1>Carrito</h1>
                        </div>
                    </div>
                </div>
           </div>
        </main>
        <?php include "reusables/footer.php" ?>
    </body>
</html>