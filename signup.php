
<?php 
    session_start();
    if (isset($_SESSION["code"]) && isset($_SESSION["email"]) && isset($_SESSION["username"])) {
        header("Location: index.php");
    }  
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="public/errea-logo.png" type="image/x-icon">
        <link rel="stylesheet" href="assets/styles/module.css">
        <link rel="stylesheet" href="assets/styles/auth.css">
        <script src="assets/scripts/auth/signup.js"></script>
        <title>Registro | Errea</title>
    </head>
    <body class="light-theme">
        <div class="container">
            <form id="signup" class="card" method="POST">
                <div class="card-header">
                    <h1 style="margin-top: 20px">Registro de cuenta</h1>
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
                        <button type="submit">Registrar</button>
                    </div>
                    <div>
                        <p>¿Ttienes una cuenta?</p>
                        <a href="signin.php">Iniciar</a>
                    </div>
                </div>
            </form>
            <div id="signup-modal" data-redirect="signin.php" class="modal">
                <p id="status"></p>
                <div>
                    <button id="button" type="button">Aceptar</button>
                </div>
            </div>
        </div>
    </body>
</html>
