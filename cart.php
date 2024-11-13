<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="es">
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
    <title>Carrito | Errea</title>
    <link rel="shortcut icon" href="public/icons/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/styles/module.css">
    <link rel="stylesheet" href="assets/styles/navbar.css">
    <link rel="stylesheet" href="assets/styles/footer.css">
    <link rel="stylesheet" href="assets/styles/cart.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assets/scripts/navbar.js"></script>
</head>
<body>
    <?php include "reusables/navbar.php" ?>
    <main>
        <div class="container">
            <div class="cart">
                <div class="product">
                    <div class="product-info">
                        <img src="notebook.png" alt="Notebook">
                        <p>Notebook Aorus 15 MF-E7A143SH</p>
                    </div>
                    <div class="product-price">US$1,390.00</div>
                    <div class="product-quantity">
                        <button>-</button>
                        <input type="text" value="1" style="width: 30px; text-align: center;">
                        <button>+</button>
                    </div>
                    <div class="product-subtotal">US$1,390.00</div>
                </div>

                <div class="product">
                    <div class="product-info">
                        <img src="monitor.png" alt="Monitor">
                        <p>Monitor Viewsonic VX3418-2KC</p>
                    </div>
                    <div class="product-price">US$625.00</div>
                    <div class="product-quantity">
                        <button>-</button>
                        <input type="text" value="1" style="width: 30px; text-align: center;">
                        <button>+</button>
                    </div>
                    <div class="product-subtotal">US$625.00</div>
                </div>

                <div class="product">
                    <div class="product-info">
                        <img src="teclado.png" alt="Teclado">
                        <p>Teclado Mecánico Corsair K95 RGB</p>
                    </div>
                    <div class="product-price">US$199.00</div>
                    <div class="product-quantity">
                        <button>-</button>
                        <input type="text" value="1" style="width: 30px; text-align: center;">
                        <button>+</button>
                    </div>
                    <div class="product-subtotal">US$199.00</div>
                </div>

                <div class="product">
                    <div class="product-info">
                        <img src="mouse.png" alt="Mouse">
                        <p>Mouse Logitech MX Master 3</p>
                    </div>
                    <div class="product-price">US$99.00</div>
                    <div class="product-quantity">
                        <button>-</button>
                        <input type="text" value="1" style="width: 30px; text-align: center;">
                        <button>+</button>
                    </div>
                    <div class="product-subtotal">US$99.00</div>
                </div>

                <div class="product">
                    <div class="product-info">
                        <img src="audifonos.png" alt="Audífonos">
                        <p>Audífonos Sony WH-1000XM4</p>
                    </div>
                    <div class="product-price">US$349.00</div>
                    <div class="product-quantity">
                        <button>-</button>
                        <input type="text" value="1" style="width: 30px; text-align: center;">
                        <button>+</button>
                    </div>
                    <div class="product-subtotal">US$349.00</div>
                </div>
            </div>

            <div class="summary">
                <div class="summary-header"><h3>Totales del Carrito</h3></div>
                <div class="summary-body">
                    <p>Subtotal: <span>US$2,662.00</span></p>
                    <p><strong>Envío</strong></p>
                    <label><input type="radio" name="shipping" value="pickup" checked>Retiro en el local</label><br>
                    <label><input type="radio" name="shipping" value="free">Envío - GRATIS</label><br>
                    <p>Total: <span>US$2,662.00</span></p>
                </div>
                <div class="summary-footer">
                    <button id="finalizePurchase" class="btn btn-primary btn-lg">Finalizar compra</button>
                </div>
            </div>
        </div>
    </main>
    <?php include "reusables/footer.php" ?>

    <script>
        document.getElementById("finalizePurchase").addEventListener("click", function(event) {
            event.preventDefault();

            Swal.fire({
                title: '¡Gracias por tu compra!',
                text: 'Tu pedido ha sido realizado con éxito.',
                icon: 'success',
                confirmButtonText: 'Cerrar'
            });
        });
    </script>
</body>
</html>
