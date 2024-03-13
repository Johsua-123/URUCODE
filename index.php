<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="POST">
        <input type="email" name="email" placeholder="example@gmail.com">
        <input type="text" name="username" placeholder="nombre de usuario">
        <input type="password" name="password" placeholder="contraseña">
        <button type="submit">Enviar</button>
    </form>

    <?php 

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            // Asignamos variables de los datos ingresados en el formulario
            $email = $_POST['email'];
            $username= $_POST['username'];
            $password = $_POST['password'];

            // Mostramos los datos recuperados del formulario
            echo "<h1>Datos ingresados<h1>";
            echo "<h3>Email: $email</h3>";
            echo "<h3>Username: $username</h3>";
            echo "<h3>Password: $password</h3>";

        }
    ?>
</body>
</html>