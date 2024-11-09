<?php 
session_start();
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
    <title>Checkout | Errea</title>
    <link rel="shortcut icon" href="public/icons/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/styles/module.css">
    <link rel="stylesheet" href="assets/styles/navbar.css">
    <link rel="stylesheet" href="assets/styles/footer.css">
    <link rel="stylesheet" href="assets/styles/checkout.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/scripts/navbar.js"></script>
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
        <div class="row">
            <!-- Detalles de facturación -->
            <div class="column">
                <div class="card">
                    <div class="card-header">
                        <h4>Detalles de facturación</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="firstName">Nombre<span class="text-danger">*</span></label>
                            <input type="text" id="firstName" required>
                        </div>
                        <div class="form-group">
                            <label for="lastName">Apellido<span class="text-danger">*</span></label>
                            <input type="text" id="lastName" required>
                        </div>
                        <div class="form-group">
                            <label for="idNumber">Documento de identidad<span class="text-danger">*</span></label>
                            <input type="text" id="idNumber" required>
                        </div>
                        <div class="form-group">
                            <label for="country">País / Región</label>
                            <input type="text" id="country" value="Uruguay" readonly>
                        </div>
                        <div class="form-group">
                            <label for="address">Dirección de la calle<span class="text-danger">*</span></label>
                            <input type="text" id="address" placeholder="Número de casa y nombre de la calle" required>
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="Apartamento, habitación, etc. (opcional)">
                        </div>
                        <div class="form-group">
                            <label for="city">Ciudad<span class="text-danger">*</span></label>
                            <input type="text" id="city" required>
                        </div>
                        <div class="form-group">
                            <label for="state">Departamento<span class="text-danger">*</span></label>
                            <input type="text" id="state" value="Montevideo" readonly>
                        </div>
                        <div class="form-group">
                            <label for="phone">Teléfono<span class="text-danger">*</span></label>
                            <input type="tel" id="phone" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Dirección de correo electrónico<span class="text-danger">*</span></label>
                            <input type="email" id="email" required>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Tu pedido -->
            <div class="column">
                <div class="card">
                    <div class="card-header">
                        <h4>Tu Pedido</h4>
                    </div>
                    <div class="card-body">
                        <p><strong>PRODUCTO</strong></p>
                        <p>Equipo INTEL Core i5 10400F Full Gamer - 16GB - SSD PCIe - Radeon RX6700XT 12Gb x 1</p>
                        <p><strong>US$900.00</strong></p>
                        <hr>
                        <p><strong>Subtotal</strong> <span class="float-end">US$900.00</span></p>
                        <p><strong>Envío</strong></p>
                        <div class="form-check">
                            <input type="radio" name="shipping" id="pickup" value="pickup" class="form-check-input" checked>
                            <label for="pickup" class="form-check-label">Retiro en el local</label>
                        </div>
                        <div class="form-group">
                            <label for="pickupName">Nombre de quien retira</label>
                            <input type="text" id="pickupName">
                        </div>
                        <div class="form-group">
                            <label for="pickupId">Cédula de quien retira</label>
                            <input type="text" id="pickupId">
                        </div>
                        <div class="form-check">
                            <input type="radio" name="shipping" id="montevideoFlex" value="montevideoFlex" class="form-check-input">
                            <label for="montevideoFlex" class="form-check-label">Envio a todo el pais - GRATIS</label>
                        </div>
                        <hr>
                        <p><strong>Total</strong> <span class="float-end">US$900.00</span></p>
                        <p><strong>Métodos de pago</strong></p>
                        <div class="form-check">
                            <input type="radio" name="paymentMethod" id="bankTransfer" value="bankTransfer" class="form-check-input">
                            <label for="bankTransfer" class="form-check-label">Transferencia bancaria</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="paymentMethod" id="redpagos" value="redpagos" class="form-check-input">
                            <label for="redpagos" class="form-check-label">Abitab / Redpagos</label>
                        </div>
                        <hr>
                        <div class="form-check">
                            <input type="checkbox" id="termsConditions" class="form-check-input" required>
                            <label for="termsConditions" class="form-check-label">He leído y estoy de acuerdo con los <a href="#">términos y condiciones de la web</a>.</label>
                        </div>
                        <button class="btn btn-primary btn-lg btn-block" id="placeOrder">REALIZAR EL PEDIDO</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </main>
    <?php include "reusables/footer.php" ?>
</body>
</html>

