
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
        <link rel="stylesheet" href="assets/styles/module.css">
        <script src="assets/scripts/modal.js"></script>
        <title>Registro | Errea</title>
    </head>
    <body>
        <div class="container">
            <form class="card" method="POST">
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
                        <button type="submit">Registro</button>
                    </div>
                    <div>
                        <p>¿Ya tienes una cuenta?</p>
                        <a href="signin.php">Iniciar</a>
                    </div>
                </div>
            </form>
            <div id="modal" data-redirect="signin.php" class="modal">
                <p id="status"></p>
                <div>
                    <button id="button" type="button">Aceptar</button>
                </div>
            </div>
        </div>
    </body>
</html>

<?php 

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        exit;
    }

    if (!isset($_POST["email"]) || !isset($_POST["username"]) || !isset($_POST["password"])) {
        exit;
    }

    if (empty(trim($_POST["email"])) || empty(trim($_POST["username"])) || empty(trim($_POST["password"]))) {
        header("Location: signup.php?status=" . urldecode("Porfavor completa todos los campos"));
        exit;
    }

    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    require "mysql.php";
    $query = mysqli_query($mysql, "SELECT * FROM usuarios WHERE email='$email'");
    
    $results = [];
    while ($result = mysqli_fetch_assoc($query)) {
        $results[] = $result;
    }

    if (!empty($results)) {
        header("Location: signup.php?status=" . urldecode("Correo electrónico ya registrado"));
        exit;
    }
    
    $user = mysqli_query($mysql, "INSERT INTO usuarios (email, username, password) VALUES ('$email', '$username', '$password')");
    
    if (!$user) {
        header("Location: signup.php?status=" . urldecode("Porfavor intenta mas tarde"));
        exit;
    }

    header("Location: signup.php?status=" . urldecode("Cuenta registrada exitosamente"));
    
?>