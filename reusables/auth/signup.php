<?php
session_start();
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["registro"])) {
        $usuario = $_POST["usuario"];
        $correo = $_POST["correo"];
        $contraseña = $_POST["contraseña"];

        $query = "INSERT INTO usuarios (correo, contraseña, usuario) VALUES ('$correo', '$contraseña', '$usuario')";
        mysqli_query($conexion, $query) or die ("error al registrar" . mysqli_error($conexion));

        exit();
    } elseif (isset($_POST["login"])) {
        $correo = $_POST["correo"];
        $contraseña = $_POST["contraseña"];

        $query = "SELECT * FROM usuarios WHERE correo='$correo' AND contraseña='$contraseña'";
        $result = mysqli_query($conexion, $query);

        if (mysqli_num_rows($result) > 0) {
            $_SESSION["usuario"] = $correo;
            header("Location: index.php");
            exit();
        } else {
            echo "Correo o contraseña incorrectos.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="login.css">
    <link rel="icon" href="assets/images/Favicon/favicon-32x32.png">
    <title>Registro-Inicio Sesion</title>
</head>
<body>
    <div class="container-form register">
        <div class="information">
            <div class="info-childs">
                <h2>Bienvenido</h2>
                <p>Para unirte a nuestra comunidad por favor Inicia Sesión con tus datos</p>
                <input type="button" value="Iniciar Sesión" id="sign-in">
            </div>
        </div>
        <div class="form-information">
            <div class="form-information-childs">
                <h2>Crear una Cuenta</h2>
                <div class="icons">
                    <i class='bx bxl-google'></i>
                </div>
                <p>o usa tu email para registrarte</p>
                <form class="form form-register" method="POST" novalidate>
                    <div>
                        <label>
                            <i class='bx bx-user' ></i>
                            <input type="text" placeholder="Nombre Usuario" name="usuario">
                        </label>
                    </div>
                    <div>
                        <label >
                            <i class='bx bx-envelope' ></i>
                            <input type="email" placeholder="Correo Electronico" name="correo">
                        </label>
                    </div>
                   <div>
                        <label>
                            <i class='bx bx-lock-alt' ></i>
                            <input type="password" placeholder="Contraseña" name="contraseña">
                        </label>
                   </div>
                    <input type="submit" value="Registrarse" name="registro">
                    <div class="alerta-error">Todos los campos son obligatorios</div>
                    <div class="alerta-exito">Te registraste correctamente</div>
                </form>
            </div>
        </div>
    </div>

    <div class="container-form login hide">
        <div class="information">
            <div class="info-childs">
                <h2>¡¡Bienvenido nuevamente!!</h2>
                <p>Para unirte a nuestra comunidad por favor Inicia Sesión con tus datos</p>
                <input type="button" value="Registrarse" id="sign-up">
            </div>
        </div>
        <div class="form-information">
            <div class="form-information-childs">
                <h2>Iniciar Sesión</h2>
                <div class="icons">
                    <i class='bx bxl-google'></i>
                </div>
                <p>o Iniciar Sesión con una cuenta</p>
                <form class="form form-login" method="POST" novalidate>
                    <div>
                        <label >
                            <i class='bx bx-envelope' ></i>
                            <input type="email" placeholder="Correo Electronico" name="correo">
                        </label>
                    </div>
                    <div>
                        <label>
                            <i class='bx bx-lock-alt' ></i>
                            <input type="password" placeholder="Contraseña" name="contraseña">
                        </label>
                    </div>
                    <input type="submit" value="Iniciar Sesión" name="login">
                    <div class="alerta-error">Todos los campos son obligatorios</div>
                    <div class="alerta-exito">Te registraste correctamente</div>
                </form>
            </div>
        </div>
    </div>
    <script src="assets/scripts/login.js"></script>
</body>
</html>
