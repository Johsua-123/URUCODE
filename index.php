
<?php 
    session_start();
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="public/errea-logo.png" type="image/x-icon">
        <link rel="stylesheet" href="assets/styles/module.css">
        <link rel="stylesheet" href="assets/styles/slider.css">
        <script src="assets/scripts/slider.js"></script>
        <title>Inicio - Errea</title>
    </head>
    <body class="light-theme">

        <?php include "reusables/navbar.php"; ?>
        
        <!-- Slider -->
        <div class="slider-wrapper">
            <div id="slider" class="slides">
                <img src="public/banners/slider-1.png" alt="slider image 1">
                <img src="public/banners/slider-2.png" alt="slider image 2">
                <img src="public/banners/slider-3.png" alt="slider image 3">
                <img src="public/banners/slider-4.png" alt="slider image 4">
                <img src="public/banners/slider-5.png" alt="slider image 5">
            </div>
        </div>
    
        <?php //include "reusables/footer.php" ?>
    </body> 
</html>
