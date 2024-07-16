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
    <link rel="stylesheet" href="assets/styles/navbar.css">
    <link rel="stylesheet" href="assets/styles/footer.css">
    <link rel="stylesheet" href="assets/styles/master.css">
    <script src="assets/scripts/navbar.js"></script>
    <script src="assets/scripts/slider.js"></script>
    <title>Inicio - Errea</title>
</head>
<body>
    <?php include "reusables/navbar.php"; ?>
    <main>
        <div class="slider">
            <div id="slider" class="slides">
                <img src="public/banners/slider-1.png" alt="slider image 1">
                <img src="public/banners/slider-2.png" alt="slider image 2">
                <img src="public/banners/slider-3.png" alt="slider image 3">
                <img src="public/banners/slider-4.png" alt="slider image 4">
                <img src="public/banners/slider-5.png" alt="slider image 5">
            </div>
        </div>
        <div class="products">
            <h1>Destacados</h1>
            <div class="product-items">
                <div class="product-card">
                    <div class="card-header">
                        <img src="https://via.placeholder.com/100x100?text=Imagen+del+Producto" alt="imagen producto 1">
                    </div>
                    <div class="card-footer">

                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php include "reusables/footer.php"; ?>
</body> 
</html>
