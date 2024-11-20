<?php 
session_start();

require 'api/mysql.php';

if (isset($_GET["codigo"])) {
    $codigoProducto = $_GET["codigo"];

    $stmt = $mysql->prepare("SELECT * FROM productos WHERE codigo = ?");
    $stmt->bind_param("i", $codigoProducto);
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

        $imagenProducto = $imagen ? 'ruta/a/imagenes/' . $imagen['nombre'] : 'https://via.placeholder.com/150';
        $nombreProducto = $producto['nombre'];
        $descripcionProducto = $producto['descripcion'];
        $precioProducto = $producto['precio_venta'];
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
    <link rel="shortcut icon" href="public/icons/errea.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/styles/module.css">
    <link rel="stylesheet" href="assets/styles/navbar.css">
    <link rel="stylesheet" href="assets/styles/footer.css">
    <link rel="stylesheet" href="assets/styles/compra.css">
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
        <form method="POST" action="api/checkout-2.php">
    <input type="hidden" name="codigoProducto" value="<?php echo $codigoProducto; ?>">
    <input type="hidden" name="precioProducto" value="<?php echo $producto['precio_venta'] ?? $servicio['precio']; ?>">
    <input type="hidden" name="cantidadProducto" value="1"> 
    <input type="hidden" name="tipoItem" value="productos"> 
    <div class="container">
        <div class="row">
            <div class="column">
                <div class="card">
                    <div class="card-header">
                        <h4>Detalles de facturación</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nombreCliente">Nombre<span class="text-danger">*</span></label>
                            <input type="text" id="nombreCliente" name="nombreCliente" required>
                        </div>
                        <div class="form-group">
                            <label for="apellidoCliente">Apellido<span class="text-danger">*</span></label>
                            <input type="text" id="apellidoCliente" name="apellidoCliente" required>
                        </div>
                        <div class="form-group">
                            <label for="documentoCliente">Documento de identidad<span class="text-danger">*</span></label>
                            <input type="text" id="documentoCliente" name="documentoCliente" required>
                        </div>
                        <div class="form-group">
                            <label for="paisCliente">País / Región</label>
                            <input type="text" id="paisCliente" name="paisCliente" value="Uruguay" readonly>
                        </div>
                        <div class="form-group">
                            <label for="direccionCliente">Dirección de la calle<span class="text-danger">*</span></label>
                            <input type="text" id="direccionCliente" name="direccionCliente" placeholder="Número de casa y nombre de la calle" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="apartamentoCliente" placeholder="Apartamento, habitación, etc. (opcional)">
                        </div>
                        <div class="form-group">
                            <label for="ciudadCliente">Ciudad<span class="text-danger">*</span></label>
                            <input type="text" id="ciudadCliente" name="ciudadCliente" required>
                        </div>
                        <div class="form-group">
                            <label for="departamentoCliente">Departamento<span class="text-danger">*</span></label>
                            <select id="departamentoCliente" name="departamentoCliente" required>
                                <option value="" disabled selected>Selecciona un departamento</option>
                                <option value="Artigas">Artigas</option>
                                <option value="Canelones">Canelones</option>
                                <option value="Cerro Largo">Cerro Largo</option>
                                <option value="Colonia">Colonia</option>
                                <option value="Durazno">Durazno</option>
                                <option value="Flores">Flores</option>
                                <option value="Florida">Florida</option>
                                <option value="Lavalleja">Lavalleja</option>
                                <option value="Maldonado">Maldonado</option>
                                <option value="Montevideo">Montevideo</option>
                                <option value="Paysandú">Paysandú</option>
                                <option value="Río Negro">Río Negro</option>
                                <option value="Rivera">Rivera</option>
                                <option value="Rocha">Rocha</option>
                                <option value="Salto">Salto</option>
                                <option value="San José">San José</option>
                                <option value="Soriano">Soriano</option>
                                <option value="Tacuarembó">Tacuarembó</option>
                                <option value="Treinta y Tres">Treinta y Tres</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="telefonoCliente">Teléfono<span class="text-danger">*</span></label>
                            <input type="tel" id="telefonoCliente" name="telefonoCliente" required>
                        </div>
                        <div class="form-group">
                            <label for="emailCliente">Dirección de correo electrónico<span class="text-danger">*</span></label>
                            <input type="email" id="emailCliente" name="emailCliente" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="card">
                    <div class="card-header">
                        <h4>Tu Pedido</h4>
                    </div>
                    <div class="card-body">
                        <p><?php echo isset($nombreProducto) ? htmlspecialchars($nombreProducto) : 'Producto no encontrado'; ?></p>
                        <p><strong>Descripción:</strong></p>
                        <p><?php echo isset($descripcionProducto) ? htmlspecialchars($descripcionProducto) : 'Descripción no disponible'; ?></p>
                        <p><strong>Precio:</strong></p>
                        <p>$<?php echo isset($precioProducto) ? htmlspecialchars($precioProducto) : 'Precio no disponible'; ?></p>
                        <p><strong>Imagen:</strong></p>
                        <img src="<?php echo $imagenProducto; ?>" alt="Imagen del producto">
                        <hr>
                        <p><strong>Subtotal:</strong>$<?php echo isset($precioProducto) ? htmlspecialchars($precioProducto) : '0.00'; ?></p>
                        <p><strong>Envío</strong></p>
                        <div class="form-check">
                            <input type="radio" name="tipoEnvio" id="retiroLocal" value="retiroLocal" class="form-check-input" checked>
                            <label for="retiroLocal" class="form-check-label">Retiro en el local</label>
                        </div>
                        <div class="form-group">
                            <label for="nombreRetiro">Nombre de quien retira</label>
                            <input type="text" id="nombreRetiro" name="nombreRetiro">
                        </div>
                        <div class="form-group">
                            <label for="cedulaRetiro">Cédula de quien retira</label>
                            <input type="text" id="cedulaRetiro" name="cedulaRetiro">
                        </div>
                       
                        </div>
                        <hr>
                        <p><strong>Total:</strong> <span class="float-end">$<?php echo isset($precioProducto) ? htmlspecialchars($precioProducto) : '0.00'; ?></span></p>
                        
                        </div>
                        <hr>
                        <div class="form-check">
                            <input type="checkbox" id="terminosCondiciones" name="terminosCondiciones" class="form-check-input" required>
                            <label for="terminosCondiciones" class="form-check-label">He leído y estoy de acuerdo con los términos y condiciones de la web</a>.</label>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg btn-block" id="realizarPedido">REALIZAR EL PEDIDO</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
    </main>
    <?php include "reusables/footer.php" ?>
</body>
</html>

