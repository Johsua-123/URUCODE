<?php
    session_start();
    $location = "index";
?>

<!DOCTYPE html>
<html lang="en">
<head>
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-DF773N72G0"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'G-DF773N72G0');
        </script>   
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito| Errea</title>
    <link rel="shortcut icon" href="public/icons/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/styles/module.css">
    <link rel="stylesheet" href="assets/styles/navbar.css">
    <link rel="stylesheet" href="assets/styles/footer.css">
    <link rel="stylesheet" href="assets/styles/cart.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/scripts/navbar.js"></script>
</head>
<body>
    <?php include "reusables/navbar.php" ?>
    <main>
    <div class="web-path">
            <p>CARRITO > CHECKOUT > FINALIZAR COMPRA</p>
        </div>
        <div class="container">
        <div class="cart">
            <div class="product">
                <div class="product-info">
                    <img src="notebook.png" alt="Notebook">
                    <div>
                        <p>Notebook Aorus 15 MF-E7A143SH Core i5 12500H/8Gb/SSD PCIe 512Gb/RTX 4050/15.6 360Hz/W11</p>
                    </div>
                </div>
                <div class="product-price">
                    <p>US$1,390.00</p>
                </div>
                <div class="product-quantity">
                    <button>-</button>
                    <input type="text" value="1" style="width: 30px; text-align: center;">
                    <button>+</button>
                </div>
                <div class="product-subtotal">
                    <p>US$1,390.00</p>
                </div>
            </div>
            <div class="product">
                <div class="product-info">
                    <img src="monitor.png" alt="Monitor">
                    <div>
                        <p>Monitor Viewsonic VX3418-2KC 144Hz 1ms 3440 x 1440 34"</p>
                    </div>
                </div>
                <div class="product-price">
                    <p>US$625.00</p>
                </div>
                <div class="product-quantity">
                    <button>-</button>
                    <input type="text" value="1" style="width: 30px; text-align: center;">
                    <button>+</button>
                </div>
                <div class="product-subtotal">
                    <p>US$625.00</p>
                </div>
            </div>
        </div>
        <div class="summary">
            <div class="summary-header">
                <h3>Totales del Carrito</h3>
            </div>
            <div class="summary-body">
                <p>Subtotal: <span style="float: right;">US$2,015.00</span></p>
                <p><strong>Envío</strong></p>
                <label><input type="radio" name="shipping" value="pickup" checked>Retiro en el local</label><br>
                <label><input type="radio" name="shipping" value="montevideoFlex">Envio a todo el pais - GRATIS</label><br>
                <p>Total: <span style="float: right;">US$2,015.00</span></p>
            </div>
            <div class="summary-footer">
                <button class="btn btn-primary btn-lg">Finalizar compra</button>
            </div>
        </div>
    </div>
    </main>
    <?php include "reusables/footer.php" ?>
</body>
</html>