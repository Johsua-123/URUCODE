<?php 
session_start();

if (isset($_GET['codigo'])) {
    $product_code = $_GET['codigo'];

    $servername = "localhost";
    $username = "duenio";
    $password = "duenio";
    $dbname = "urucode";

    $mysql = new mysqli($servername, $username, $password, $dbname);
    if ($mysql->connect_error) {
        die("Error de conexión a la base de datos: " . $mysql->connect_error);
    }

    $stmt = $mysql->prepare("SELECT * FROM productos WHERE codigo = ?");
    $stmt->bind_param("i", $product_code);
    $stmt->execute();
    $result = $stmt->get_result();
    $producto = $result->fetch_assoc();

    if ($producto) {
        $imagen_id = $producto['imagen_id'];
        $stmt = $mysql->prepare("SELECT nombre FROM imagenes WHERE codigo = ?");
        $stmt->bind_param("i", $imagen_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $imagen = $result->fetch_assoc();

        $imagen_url = $imagen ? 'ruta/a/imagenes/' . $imagen['nombre'] : 'https://via.placeholder.com/150';
    } else {
        echo "Producto no encontrado.";
        exit;
    }

    $stmt->close();
    $mysql->close();
} else {
    echo "Código de producto no especificado.";
    exit;
}
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
    <script src="assets/scripts/checkout.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/scripts/navbar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js"></script>
</head>
<body>
    <?php include "reusables/navbar.php" ?>
    <main>
        <div class="web-path">
            <p>CARRITO > CHECKOUT > FINALIZAR COMPRA</p>
        </div>
        <form method="POST" action="api/checkout.php">
    <input type="hidden" name="productCode" value="<?php echo $product_code; ?>">
    <input type="hidden" name="amount" value="<?php echo $producto['precio_venta']; ?>">
    <input type="hidden" name="quantity" value="1"> <!-- Campo quantity añadido -->
    <div class="container">
        <div class="row">
            <div class="column">
                <div class="card">
                    <div class="card-header">
                        <h4>Detalles de facturación</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="firstName">Nombre<span class="text-danger">*</span></label>
                            <input type="text" id="firstName" name="firstName" required>
                        </div>
                        <div class="form-group">
                            <label for="lastName">Apellido<span class="text-danger">*</span></label>
                            <input type="text" id="lastName" name="lastName" required>
                        </div>
                        <div class="form-group">
                            <label for="idNumber">Documento de identidad<span class="text-danger">*</span></label>
                            <input type="text" id="idNumber" name="idNumber" required>
                        </div>
                        <div class="form-group">
                            <label for="country">País / Región</label>
                            <input type="text" id="country" name="country" value="Uruguay" readonly>
                        </div>
                        <div class="form-group">
                            <label for="address">Dirección de la calle<span class="text-danger">*</span></label>
                            <input type="text" id="address" name="address" placeholder="Número de casa y nombre de la calle" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="apartment" placeholder="Apartamento, habitación, etc. (opcional)">
                        </div>
                        <div class="form-group">
                            <label for="city">Ciudad<span class="text-danger">*</span></label>
                            <input type="text" id="city" name="city" required>
                        </div>
                        <div class="form-group">
                            <label for="state">Departamento<span class="text-danger">*</span></label>
                            <input type="text" id="state" name="state" value="Montevideo" readonly>
                        </div>
                        <div class="form-group">
                            <label for="phone">Teléfono<span class="text-danger">*</span></label>
                            <input type="tel" id="phone" name="phone" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Dirección de correo electrónico<span class="text-danger">*</span></label>
                            <input type="email" id="email" name="email" required>
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
                        <p><?php echo isset($producto['nombre']) ? htmlspecialchars($producto['nombre']) : 'Producto no encontrado'; ?></p>
                        <p><strong>Descripción:</strong></p>
                        <p><?php echo isset($producto['descripcion']) ? htmlspecialchars($producto['descripcion']) : 'Descripción no disponible'; ?></p>
                        <p><strong>Precio:</strong></p>
                        <p>$<?php echo isset($producto['precio_venta']) ? htmlspecialchars($producto['precio_venta']) : 'Precio no disponible'; ?></p>
                        <p><strong>Imagen:</strong></p>
                        <img src="<?php echo $imagen_url; ?>" alt="Imagen del producto">
                        <hr>
                        <p><strong>Subtotal:</strong>$<?php echo isset($producto['precio_venta']) ? htmlspecialchars($producto['precio_venta']) : '0.00'; ?></p>
                        <p><strong>Envío</strong></p>
                        <div class="form-check">
                            <input type="radio" name="shipping" id="pickup" value="pickup" class="form-check-input" checked>
                            <label for="pickup" class="form-check-label">Retiro en el local</label>
                        </div>
                        <div class="form-group">
                            <label for="pickupName">Nombre de quien retira</label>
                            <input type="text" id="pickupName" name="pickupName">
                        </div>
                        <div class="form-group">
                            <label for="pickupId">Cédula de quien retira</label>
                            <input type="text" id="pickupId" name="pickupId">
                        </div>
                        <div class="form-check">
                            <input type="radio" name="shipping" id="montevideoFlex" value="montevideoFlex" class="form-check-input">
                            <label for="montevideoFlex" class="form-check-label">Envío a todo el país - GRATIS</label>
                        </div>
                        <hr>
                        <p><strong>Total:</strong> <span class="float-end">$<?php echo isset($producto['precio_venta']) ? htmlspecialchars($producto['precio_venta']) : '0.00'; ?></span></p>
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
                            <input type="checkbox" id="termsConditions" name="termsConditions" class="form-check-input" required>
                            <label for="termsConditions" class="form-check-label">He leído y estoy de acuerdo con los <a href="#">términos y condiciones de la web</a>.</label>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg btn-block" id="placeOrder">REALIZAR EL PEDIDO</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

    </main>
    <?php include "reusables/footer.php" ?>

    <script>
    document.getElementById("placeOrder").addEventListener("click", function(event) {
        event.preventDefault();

        let firstName = document.getElementById("firstName").value.trim();
        let lastName = document.getElementById("lastName").value.trim();
        let idNumber = document.getElementById("idNumber").value.trim();
        let address = document.getElementById("address").value.trim();
        let city = document.getElementById("city").value.trim();
        let phone = document.getElementById("phone").value.trim();
        let email = document.getElementById("email").value.trim();
        let termsConditions = document.getElementById("termsConditions").checked;

        if (firstName && lastName && idNumber && address && city && phone && email && termsConditions) {
            Swal.fire({
                title: '¡Gracias por tu compra!',
                text: 'Tu pedido ha sido realizado con éxito.',
                icon: 'success',
                confirmButtonText: 'Cerrar'
            }).then(() => {
                document.querySelector("form").submit();
            });
        } else {
            Swal.fire({
                title: 'Error',
                text: 'Hubo un error al completar la transacción. Por favor, verifica que todos los campos estén completos.',
                icon: 'error',
                confirmButtonText: 'Cerrar'
            });
        }
    });
</script>
</body>
</html>

