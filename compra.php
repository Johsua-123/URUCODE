<?php
session_start();

require "api/mysql.php";

if (isset($_GET["codigo"])) {
    $codigoProducto = $_GET["codigo"];

    $stmt = $mysql->prepare("
        SELECT p.nombre, p.descripcion, p.precio_venta, i.nombre AS imagen
        FROM productos p
        LEFT JOIN imagenes i ON p.imagen_id = i.codigo
        WHERE p.codigo = ?
    ");
    $stmt->bind_param("i", $codigoProducto);
    $stmt->execute();
    $result = $stmt->get_result();
    $producto = $result->fetch_assoc();

    if (!$producto) {
        echo "Producto no encontrado.";
        exit;
    }

    $nombreProducto = $producto["nombre"];
    $descripcionProducto = $producto["descripcion"];
    $precioProducto = $producto["precio_venta"];
    $imagenProducto = $producto["imagen"] 
        ? "public/images/{$producto["imagen"]}" 
        : "https://via.placeholder.com/150";

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
        gtag("js", new Date());
        gtag("config", "G-DF773N72G0");
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
</head>
<body>
    <?php include "reusables/navbar.php"; ?>
    <main>
        <div class="web-path">
            <p>CARRITO > CHECKOUT > FINALIZAR COMPRA</p>
        </div>
        <form method="POST" action="api/checkout-2.php">
            <input type="hidden" name="codigoProducto" value="<?= $codigoProducto ?>">
            <input type="hidden" name="precioProducto" value="<?= $precioProducto ?>">
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
                                    <label for="direccionCliente">Dirección de la calle<span class="text-danger">*</span></label>
                                    <input type="text" id="direccionCliente" name="direccionCliente" required>
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
                                        <?php
                                        $departamentos = [
                                            "Artigas", "Canelones", "Cerro Largo", "Colonia", "Durazno", "Flores",
                                            "Florida", "Lavalleja", "Maldonado", "Montevideo", "Paysandú", "Río Negro",
                                            "Rivera", "Rocha", "Salto", "San José", "Soriano", "Tacuarembó", "Treinta y Tres"
                                        ];
                                        foreach ($departamentos as $dep) {
                                            echo "<option value=\"$dep\">$dep</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="telefonoCliente">Teléfono<span class="text-danger">*</span></label>
                                    <input type="tel" id="telefonoCliente" name="telefonoCliente" required>
                                </div>
                                <div class="form-group">
                                    <label for="emailCliente">Correo electrónico<span class="text-danger">*</span></label>
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
                                <p><strong>Producto:</strong> <?= $nombreProducto ?></p>
                                <p><strong>Descripción:</strong> <?= $descripcionProducto ?></p>
                                <p><strong>Precio:</strong> $<?= $precioProducto ?></p>
                                <hr>
                                <p><strong>Total:</strong> $<?= $precioProducto ?></p>
                                <hr>
                                <div class="form-check">
                                    <input type="checkbox" id="terminosCondiciones" name="terminosCondiciones" required>
                                    <label for="terminosCondiciones">He leído y estoy de acuerdo con los términos y condiciones.</label>
                                </div>
                                <button type="submit" class="btn btn-primary btn-lg btn-block">REALIZAR EL PEDIDO</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </main>
    <?php include "reusables/footer.php"; ?>
</body>
</html>
