
<?php 
    session_start();
    if (isset($_SESSION["code"]) && isset($_SESSION["email"]) && isset($_SESSION["username"])) {
        header("Location: index.php");
    }
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="public/icons/logo.png" type="image/x-icon">
        <link rel="stylesheet" href="assets/styles/module.css">
        <link rel="stylesheet" href="assets/styles/auth.css">
        <script src="assets/scripts/auth/signin.js"></script>
        <title>Inicio Sesión | Errea</title>
    </head>
    <body>
        <div class="container">
            <form id="signin" class="card" method="POST">
                <div class="card-header">
                    <h1>Inicio de sesión</h1>
                </div>
                <div class="card-items">
                    <div>
                        <label for="email">Correo electrónico</label>
                        <input id="email" type="text" name="email" placeholder="ejemplo@gmail.com" autocomplete="off">
                    </div>
                    <div>
                        <label for="password">Contraseña</label>
                        <input id="password" type="password" name="password" placeholder="********" autocomplete="off">
                    </div>
                </div>
                <div class="card-footer">
                    <div>
                        <p>¿No tienes una cuenta?</p>
                        <a href="signup.php">Regístrate</a>
                    </div>
                    <div>
                        <button type="submit">Iniciar</button>
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
    </body>
</html>

