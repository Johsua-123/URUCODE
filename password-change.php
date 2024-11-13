
<?php 
    session_start();
    if (!isset($_SESSION["code"])){
        header("Location: settings.php");
    }
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
        <link rel="stylesheet" href="assets/styles/password.css">
        <script src="assets/scripts/auth/signin.js"></script>
        <title>Cambiar Contraseña | Errea</title>
    </head>
    <body>
        <div class="main-container">
        <div class="container">
            <form id="signin" class="card" method="POST" action="api/password.php">
                <div class="card-header">
                    <h1>Cambiar Contraseña</h1>
                </div>
                <div class="card-items">
                    <div>
                        <label for="email">Contraseña actual</label>
                        <input id="password_a" type="text" name="password_a" placeholder="********" autocomplete="off">
                    </div>
                    <div>
                        <label for="password">Contraseña nueva</label>
                        <input id="password_n" type="password" name="password_n" placeholder="********" autocomplete="off">
                    </div>
                </div>
                    <div class="card-footer">
                        <div>
                            <button id="iniciar" type="submit">Cambiar Contraseña</button>
                        </div>
                    </div>
                </div>
            </form>
            <div id="signin-modal" redirect="index.php" class="modal">
                <p id="status"></p>
                <div>
                    <button id="button" type="button">Aceptar</button>
                </div>
            </div>
        </div>
        </div>
    </body>
</html>

