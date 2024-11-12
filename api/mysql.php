
<?php 

    $mysql = new mysqli("127.0.0.1", "duenio", "duenio", "urucode");

    if ($mysql->connect_error) {
        die("Error al conectarse a la base de datos, porfavor comprueba la configuracion");
    }

?>