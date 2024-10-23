
<?php 
    
    session_start();

    if (!isset($_SESSION["code"])) {
        header("Location: ../index.php");
    }

    $location = "accounts";

?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="assets/styles/module.css">
        <link rel="stylesheet" href="assets/styles/navbar.css">
        <link rel="stylesheet" href="assets/styles/sidebar.css">
        <title>Cuentas | Errea Admin</title>
    </head>
    <body>
        <?php  include "reusables/sidebar.php"; ?>
        <div class="container">
            <?php include "reusables/navbar.php"; ?>
            <main style="padding-left: 10px">
                <h1>Listado de Cuentas</h1>
            </main>
        </div>
    </body>
</html>