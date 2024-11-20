<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? null;

    if ($accion === 'agregar') {
        $codigo = $_POST['codigo'] ?? null;
        $nombre = $_POST['nombre'] ?? null;
        $precio = isset($_POST['precio']) ? (float)$_POST['precio'] : null;
        $descripcion = $_POST['descripcion'] ?? null;

        if ($codigo && $nombre && $precio !== null) {
            $producto_encontrado = false;

            foreach ($_SESSION['cart'] as &$producto) {
                if ($producto['codigo'] === $codigo) {
                    $producto['cantidad']++;
                    $producto_encontrado = true;
                    break;
                }
            }

            if (!$producto_encontrado) {
                $_SESSION['cart'][] = [
                    'codigo' => $codigo,
                    'nombre' => $nombre,
                    'precio' => $precio,
                    'descripcion' => $descripcion,
                    'cantidad' => 1,
                ];
            }
        }
    } elseif ($accion === 'reiniciar') {
        $_SESSION['cart'] = [];
    }
}

function calcular_total($cart) {
    $total = 0;
    foreach ($cart as $producto) {
        $total += $producto['precio'] * $producto['cantidad'];
    }
    return $total;
}

$cart_items = $_SESSION['cart'];
$total = calcular_total($cart_items);
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
    <link rel="shortcut icon" href="public/icons/errea.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/styles/module.css">
    <link rel="stylesheet" href="assets/styles/navbar.css">
    <link rel="stylesheet" href="assets/styles/footer.css">
    <link rel="stylesheet" href="assets/styles/cart.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assets/scripts/navbar.js"></script>
</head>
<body>
    <?php include "reusables/navbar.php"; ?>

    <main>
        <div class="container">
            <h1>Carrito de Compras</h1>

            <?php if (empty($cart_items)) { ?>
                <p>Tu carrito está vacío.</p>
            <?php } else { ?>
                <div class="cart">
                    <table>
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cart_items as $producto) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                                    <td>US$<?php echo number_format($producto['precio'], 2); ?></td>
                                    <td><?php echo $producto['cantidad']; ?></td>
                                    <td>US$<?php echo number_format($producto['precio'] * $producto['cantidad'], 2); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <p><strong>Total:</strong> US$<?php echo number_format($total, 2); ?></p>

                    <form action="cart.php" method="POST">
                        <input type="hidden" name="accion" value="reiniciar">
                        <button type="submit" class="btn btn-danger">Reiniciar Carrito</button>
                    </form>
                </div>
            <?php } ?>

            <a href="tienda.php" class="btn btn-primary">Seguir comprando</a>
        </div>
    </main>
    <?php include "reusables/footer.php"; ?>
</body>
</html>
