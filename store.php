
<?php 
    session_start();
    $location = "store";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="public/icons/logo.png" type="image/x-icon">
        <link rel="stylesheet" href="assets/styles/module.css">
        <link rel="stylesheet" href="assets/styles/navbar.css">
        <link rel="stylesheet" href="assets/styles/footer.css">
        <link rel="stylesheet" href="assets/styles/store.css">
        <script src="assets/scripts/navbar.js"></script>
        <title>Tienda | Errea</title>
    </head>
    <body>
        <?php include "reusables/navbar.php" ?>

        <main>
        <div class="sidebar">
        <h2>Todas las Categorías</h2>
        <ul class="category-list">
            <li><a href="#">Tecnología</a>
                <ul>
                    <li><a href="#"> > </a></li>
                    <li><a href="#"> > </a></li>
                    <li><a href="#"> > </a></li>
                    <li><a href="#"> > </a></li>
                    <li><a href="#"> > </a></li>
                    <li><a href="#"> > </a></li>
                    <li><a href="#"> > </a></li>
                </ul>
            </li>
            <li><a href="#">Computación</a>
                <ul>
                    <li><a href="#"> > </a></li>
                    <li><a href="#"> > </a></li>
                    <li><a href="#"> > </a></li>
                    <li><a href="#"> > </a></li>
                    <li><a href="#"> > </a></li>
                    <li><a href="#"> > </a></li>
                    <li><a href="#"> > </a></li>
                    <li><a href="#"> > </a></li>
                    <li><a href="#"> > </a></li>
                    <li><a href="#"> > </a></li>
                    <li><a href="#"> > </a></li>
                    <li><a href="#"> > </a></li>
                </ul>
            </li>
        </ul>
    </div>

        <div class="main-products">
                <div class="product-items">
                    <div class="product-card">
                        <div class="card-header">
                            <img src="https://via.placeholder.com/100x100?text=Imagen+del+Producto" alt="imagen producto 1">
                        </div>
                        <div class="card-items">
                            <h1>Lenovo Gamer LQQ</h1>
                            <h2>U$S 1.499</h2>
                        </div>
                        <div class="card-footer">
                            <a href="">Ver detalles</a>
                        </div>
                    </div>
                    <div class="product-card">
                        <div class="card-header">
                            <img src="https://via.placeholder.com/100x100?text=Imagen+del+Producto" alt="imagen producto 1">
                        </div>
                        <div class="card-items">
                            <h1>Lenovo Gamer LQQ</h1>
                            <h2>U$S 1.499</h2>
                        </div>
                        <div class="card-footer">
                            <a href="">Ver detalles</a>
                        </div>
                    </div>
                    <div class="product-card">
                        <div class="card-header">
                            <img src="https://via.placeholder.com/100x100?text=Imagen+del+Producto" alt="imagen producto 1">
                        </div>
                        <div class="card-items">
                            <h1>Lenovo Gamer LQQ</h1>
                            <h2>U$S 1.499</h2>
                        </div>
                        <div class="card-footer">
                            <a href="">Ver detalles</a>
                        </div>
                    </div>
                    <div class="product-card">
                        <div class="card-header">
                            <img src="https://via.placeholder.com/100x100?text=Imagen+del+Producto" alt="imagen producto 1">
                        </div>
                        <div class="card-items">
                            <h1>Lenovo Gamer LQQ</h1>
                            <h2>U$S 1.499</h2>
                        </div>
                        <div class="card-footer">
                            <a href="">Ver detalles</a>
                        </div>
                    </div>
                    <div class="product-card">
                        <div class="card-header">
                            <img src="https://via.placeholder.com/100x100?text=Imagen+del+Producto" alt="imagen producto 1">
                        </div>
                        <div class="card-items">
                            <h1>Lenovo Gamer LQQ</h1>
                            <h2>U$S 1.499</h2>
                        </div>
                        <div class="card-footer">
                            <a href="">Ver detalles</a>
                        </div>
                    </div>
                    <div class="product-card">
                        <div class="card-header">
                            <img src="https://via.placeholder.com/100x100?text=Imagen+del+Producto" alt="imagen producto 1">
                        </div>
                        <div class="card-items">
                            <h1>Lenovo Gamer LQQ</h1>
                            <h2>U$S 1.499</h2>
                        </div>
                        <div class="card-footer">
                            <a href="">Ver detalles</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <?php include "reusables/footer.php" ?>
    </body>
</html>