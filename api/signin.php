
<?php 

    session_start();

    if (isset($_SESSION["code"])) {
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

    $query = mysqli_query($mysql, "SELECT * FROM users WHERE email='$email'");
    $users = [];

    if (!$query) {
        echo json_encode([ "code" => 500, "text" => "Ha ocurrido error, contacta un administrador" ]);
        exit;
    }

    while ($user = mysqli_fetch_assoc($query)) {
        $users[] = $user;
    }

    if (empty($users)) {
        echo json_encode([ "code" => 404, "text" => "Email o contraseña invalido" ]);
        exit;
    }

    $user = $users[0];

    if (!password_verify($password, $user["password"])) {
        echo json_encode([ "code" => 404, "text" => "Email o contraseña invalido" ]);
        exit;
    }

    $_SESSION["email"] = $email;
    $_SESSION["code"] = $user["code"];
    $_SESSION["role"] = $user["role"];
    $_SESSION["address"] = $user["address"];
    $_SESSION["surname"] = $user["surname"];
    $_SESSION["location"] = $user["location"];
    $_SESSION["username"] = $user["username"];
    $_SESSION["cellphone"] = $user["cellphone"];

    echo json_encode([ "code" => 200, "text" => "Has sido autenticado exitosamente" ]);

?>


