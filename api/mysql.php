
<?php 
    
    $mysql = new mysqli("localhost", "duenio", "duenio", "urucode");

    if ($mysql->connect_error) die("Error al conectarse a la base de datos, porfavor comprueba la configuracion");

?>