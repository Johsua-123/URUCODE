<?php 
    session_start();
    if (isset($_SESSION["code"]) && isset($_SESSION["email"]) && isset($_SESSION["username"])) {
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
        <link rel="shortcut icon" href="public/icons/logo.png" type="image/x-icon">
        <link rel="stylesheet" href="assets/styles/module.css">
        <link rel="stylesheet" href="assets/styles/signinv2.css">
        <script src="assets/scripts/auth/signup.js"></script>
    <title>SigninV2</title>
</head>
<body>
    <div class="main-container">
        <div class="left-container">
        <h1>Si ya tienes una cuenta, inicia sesion aqui</h1>
        </div>
        <div class="right-container">
                <h1>Registrate</h1>
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
                    <div class="button">
                        <button id="regis" type="submit">Registrar</button>                    
                </div>

        </div>

        </div>
    </div>
    
</body>
</html>