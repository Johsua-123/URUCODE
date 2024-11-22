
<?php 

    session_start();

    if (isset($_SESSION["code"])) {
        header("Location: ../index.php");
    }

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        header("Location: ../index.php");
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        http_response_code(405);
        exit;
    }

    if (!isset($_POST["email"]) || !isset($_POST["password"])) {
        http_response_code(400);
        exit;
    }

    $email = $_POST["email"];
    $password = $_POST["password"];

    // Verifica si los campos están vacíos o contienen solo espacios
    if (empty(trim($email)) || empty(trim($password))) {
        echo json_encode([ "text" => "Debes completar todos los campos" ]);
        http_response_code(400);
        exit;
    }

    require "mysql.php";

    // Realiza una consulta para buscar al usuario por su email
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

    if (empty($users)) {
        echo json_encode([ "text" => "Email o contraseña invalido" ]);
        http_response_code(401);
        exit;
    }

    // Obtiene el primer usuario de los resultados (debe ser único)
    $user = $users[0];

    // Verifica si la contraseña ingresada coincide con la almacenada en la base de datos
    if (!password_verify($password, $user["contrasena"])) {
        echo json_encode([ "text" => "Email o contraseña invalido" ]);
        http_response_code(401);
        exit;
    }

    $_SESSION["email"] = $email;
    $_SESSION["role"] = $user["rol"];
    $_SESSION["code"] = $user["codigo"];
    $_SESSION["username"] = $user["nombre"];
    $_SESSION["surname"] = $user["apellido"];
    $_SESSION["address"] = $user["direccion"];
    $_SESSION["location"] = $user["ubicacion"];
    $_SESSION["cellphone"] = $user["telefono"];

    echo json_encode([ "text" => "Has sido autenticado exitosamente" ]);
    http_response_code(200);

?>


