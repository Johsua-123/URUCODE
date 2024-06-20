
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
        <title>Inicio | Errea</title>
    </head>
    <body>
        <div class="container">
            <form class="card" method="POST">
                <div class="card-header">
                    <h1>Incio de sesión</h1>
                </div>
                <div class="card-items">
                    <div>
                        <label for="email">email</label>
                        <input id="email" type="text" name="email" placeholder="92279321" autocomplete="off">
                    </div>
                    <div>
                        <label for="password">Password</label>
                        <input id="password" type="password" name="password" placeholder="********" autocomplete="off">
                    </div>
                </div>
                <div class="card-footer">
                    <div>
                        <button type="submit">Signin</button>
                    </div>
                    <div>
                        <p>No tienes una cuenta?</p>
                        <a href="signup.php">Registate</a>
                    </div>
                </div>
            </form>
            <div id="modal" data-redirect="index.php" class="modal">
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
    if (!isset($_POST["email"]) || !isset($_POST["password"])) {
        exit;
    }
    if (empty(trim($_POST["email"])) || empty(trim($_POST["password"]))) {
        header("Location: signin.php?status=" . urldecode("Porfavor completa todos los campos"));
        exit;
    }

    $email = $_POST["email"];
    $password = $_POST["password"];
    require "mysql.php";
    
    $query = mysqli_query($mysql, "SELECT * FROM usuarios WHERE email='$email' AND password='$password'");
    $results = [];
    while ($result = mysqli_fetch_assoc($query)) {
        $results[] = $result;
    }
    
    if (empty($results)) {
        header("Location: signin.php?status=" . urldecode("Email o contraseña invalidos"));   
        exit;
    }

    $user = $results[0];

    $_SESSION["code"] = $user["code"];
    $_SESSION["email"] = $email;
    $_SESSION["username"] = $user["username"];

    header("Location: signin.php?status=" . urldecode("Has sido autenticado exitosamente"));

?>