
<?php 

    session_start();

    if (isset($_SESSION["code"]) && isset($_SESSION["email"]) && isset($_SESSION["username"])) {
        header("Location: index.php");
    }

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        exit;
    }

    if (!isset($_POST["email"]) || !isset($_POST["password"])) {
        exit;
    }

    $email = $_POST["email"];
    $password = $_POST["password"];

    if (empty(trim($email)) || empty(trim($password))) {
        echo json_encode([ "code" => 400, "text" => "Debes completar todos los campos" ]);
        exit;
    }

    require "mysql.php";

    $query = mysqli_query($mysql, "SELECT * FROM users WHERE email='$email' AND password='$password'");
    $users = [];

    if (!$query) {
        echo json_encode([ "code" => 500, "text" => "Ha ocurrido error, contacta un administrador" ]);
        exit;
    }

    while ($user = mysqli_fetch_assoc($query)) {
        $users[] = $user;
    }

    if (empty($users)) {
        echo json_encode([ "code" => 404, "text" => "Email o contraseña invalidas" ]);
        exit;
    }

    $user = $users[0];

    $_SESSION["code"] = $user["code"];
    $_SESSION["email"] = $email;
    $_SESSION["username"] = $user["username"];

    echo json_encode([ "code" => 200, "text" => "Has sido autenticado exitosamente" ]);

?>


