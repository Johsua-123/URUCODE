<?php 
    session_start();
    if (isset($_SESSION["code"])) {
        header("Location: index.php");
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
        <link rel="shortcut icon" href="public/icons/errea.png" type="image/x-icon">
        <link rel="stylesheet" href="assets/styles/module.css">
        <link rel="stylesheet" href="assets/styles/auth.css">
        <script src="assets/scripts/auth/signup.js"></script>
        <title>Registro | Errea</title>
    </head>
    <body>
        <div class="container">
            <form id="signup" class="card" method="POST" style="height: 550px;">
                <div class="card-header">
                    <h1>Registro de cuenta</h1>
                </div>
                <div class="card-items">
                    <div>
                        <label for="email">Email</label>
                        <input id="email" type="text" name="email" placeholder="ejemplo@gmail.com" autocomplete="off">
                    </div>
                    <div>
                        <label for="username">Usuario</label>
                        <input id="username" type="text" name="username" placeholder="ejemplo" autocomplete="off">
                    </div>
                    <div>
                        <label for="password">Contraseña</label>
                        <input id="password" type="password" name="password" placeholder="********" autocomplete="off">
                    </div>
                </div>
                <div class="card-footer">
                    <div>
                        <p>¿Tienes una cuenta?</p>
                        <a href="signin.php">Iniciar</a>
                    </div>
                    <div>
                        <button id="regis" type="submit">Registrar</button>
                    </div>
                    
                </div>
            </form>
            <div id="signup-modal" redirect="signin.php" class="modal">
                <p id="status"></p>
                <div>
                    <button id="button" type="button">Aceptar</button>
                </div>
            </div>
        </div>
    </body>
</html>
