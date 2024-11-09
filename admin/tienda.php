
<?php 

    session_start();

    if (!isset($_SESSION["code"])) {
        header("Location: ../index.php");
    }

    $location = "tienda";

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles/module.css">
    <link rel="stylesheet" href="assets/styles/navbar.css">
    <link rel="stylesheet" href="assets/styles/sidebar.css">
    <link rel="stylesheet" href="assets/styles/products.css">
    <script src="assets/scripts/products.js"></script>
    <title>Tienda | Errea Admin</title>
</head>
<body>
    <?php include "reusables/sidebar.php"; ?>
    <div class="container">
        <?php include "reusables/navbar.php"; ?>
        <main>
            <div class="users-title">
                <h1>Tienda</h1>
            </div>
        </main>
    </div>
</body>