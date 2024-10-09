
<?php 

    session_start();

    if (isset($_SESSION["code"])) {
        header("Location: index.php");
    }

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        http_response_code(400);
        exit;
    }

    if (!isset($_POST["email"]) || !isset($_POST["username"]) || !isset($_POST["password"])) {
        http_response_code(400);
        exit;
    }

    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $date = date('Y-m-d H:i:s');

    if (empty(trim($email)) || empty(trim($username)) || empty(trim($password))) {
        echo json_encode([ "text" => "Debes completar todos los campos" ]);
        http_response_code(400);
        exit;
    }

    require "mysql.php";

    $query = mysqli_query($mysql, "SELECT * FROM usuarios WHERE email='$email'");
    $users = [];

    if (!$query) {
        echo json_encode([ "text" => "Ha ocurrido error, contacta un administrador" ]);
        http_response_code(500);
        exit;
    }

    while ($user = mysqli_fetch_assoc($query)) {
        $users[] = $user;
    }

    if (!empty($users)) {
        echo json_encode([ "code" => 209, "Cuenta ya registrada" ]);
        http_response_code(209);
        exit;
    }
    
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
    $user = mysqli_query($mysql, "INSERT INTO usuarios (email, nombre, contrasena, fecha_creacion, fecha_actualizacion) VALUES ('$email', '$username', '$password', '$date', '$date')");

    if (!$user) {
        echo json_encode([ "text" => "Ha ocurrido error, contacta un administrador" ]);
        http_response_code(404);
        exit;
    }

    echo json_encode([ "text" => "Cuenta registrada exitosamente" ]);
    http_response_code(200);

?>