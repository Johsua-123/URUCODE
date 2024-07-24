
<?php 

    session_start();

    if (isset($_SESSION["code"]) && isset($_SESSION["email"]) && isset($_SESSION["username"])) {
        header("Location: http://localhost/URUCODE/");
    }

    if (!isset($_POST["email"]) || !isset($_POST["username"]) || !isset($_POST["password"])) {
        exit;
    }

    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $date = date('Y-m-d H:i:s');

    if (empty(trim($email)) || empty(trim($username)) || empty(trim($password))) {
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

    if (!empty($users)) {
        echo json_encode([ "code" => 209, "Cuenta ya registrada" ]);
        exit;
    }

    $user = mysqli_query($mysql, "INSERT INTO users (email, username, password, created_at, updated_at) VALUES ('$email', '$username', '$password', '$date', '$date')");

    if (!$user) {
        echo json_encode([ "code" => 500, "text" => "Ha ocurrido error, contacta un administrador"]);
        exit;
    }

    echo json_encode([ "code" => 200, "text" => "Cuenta registrada exitosamente" ]);
    
?>