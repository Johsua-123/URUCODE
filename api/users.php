
<?php

    session_start();

    if (!isset($_SESSION["code"])) {
        exit;
    }

    $method = $_SERVER["REQUEST_METHOD"];
    $code = $_SESSION["code"];
    require "mysql.php";

    if ($method == "PUT") {

        if (!isset($_POST["username"]) || !isset($_POST["surname"]) || !isset($_POST["location"]) || !isset(($_POST["address"])) || !isset($_POST["cellphone"]) || !isset($_POST["email"])) {
            exit;
        }

        $query = mysqli_query($mysql, "SELECT * FROM users WHERE code=$code");
        $results = [];

        if (!$query) {
            echo json_encode([ "code" => 500, "text" => "Ha ocurrido error, contacta un administrador" ]);
            exit;
        }

        while ($user = mysqli_fetch_assoc($query)) {
            $users[] = $user;
        }
    
        if (empty($users)) {
            echo json_encode([ "code" => 404, "Usuario no encontrada" ]);
            exit;
        }

        $user = $users[0];
        $sql = "UPDATE SET";

        if (!empty($_POST["username"]) && $_POST["username"] != $user["username"]) {
            $sql = $sql . " username=" . $_POST["username"];
        }

        if (!empty($_POST["surname"]) && $_POST["surname"] != $user["surname"]) {
            $sql = $sql . ", surname=". $_POST["surname"];
        }

        if (!empty($_POST["location"]) && $_POST["location"]) {
            $sql = $sql . ", location=". $_POST["location"];
        }

        if (!empty($_POST["address"]) && $_POST["address"] != $user["address"]) {
            $sql = $sql . ", address=". $_POST["address"];
        }

        if (!empty($_POST["cellphone"]) && $_POST["cellphone"] != $user["cellphone"]) {
            $sql = $sql . ", $cellphone". $_POST["cellphone"];
        }

        $query = mysqli_query($mysql, "$sql WHERE code=$code");

        if (!$query) {
            echo json_encode([ "code" => 500, "text" => "Ha ocurrido error, contacta un administrador" ]);
            exit;
        }

        echo json_encode([ "code" => 200 ]);

        exit;
    }

    if ($method == "GET") {

        exit;
    }

    if ($method == "DELETE") {

        exit;
    }

?>