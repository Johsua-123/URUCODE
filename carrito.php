<?php
session_start();

if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = [];
}

function agregar_producto($codigo, $nombre, $precio, $descripcion) {
    foreach ($_SESSION["cart"] as &$producto) {
        if ($producto["codigo"] === $codigo) {
            $producto["cantidad"]++;
            return;
        }
    }

    $_SESSION["cart"][] = [
        "codigo" => $codigo,
        "nombre" => $nombre,
        "precio" => $precio,
        "descripcion" => $descripcion,
        "cantidad" => 1,
    ];
}

function reiniciar_carrito() {
    $_SESSION["cart"] = [];
}

function calcular_total() {
    return array_reduce($_SESSION["cart"], function ($total, $producto) {
        return $total + $producto["precio"] * $producto["cantidad"];
    }, 0);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $accion = $_POST["accion"] ?? null;

    if ($accion === "agregar") {
        $codigo = $_POST["codigo"] ?? null;
        $nombre = $_POST["nombre"] ?? null;
        $precio = isset($_POST["precio"]) ? (float)$_POST["precio"] : null;
        $descripcion = $_POST["descripcion"] ?? null;

        if ($codigo && $nombre && $precio !== null) {
            agregar_producto($codigo, $nombre, $precio, $descripcion);
        }
    } elseif ($accion === "reiniciar") {
        reiniciar_carrito();
    }
}
$cart_items = $_SESSION["cart"];
$total = calcular_total();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito | Errea</title>
    <link rel="shortcut icon" href="public/icons/errea.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/styles/module.css">
    <link rel="stylesheet" href="assets/styles/navbar.css">
    <link rel="stylesheet" href="assets/styles/footer.css">
    <link rel="stylesheet" href="assets/styles/carrito.css">
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
                                    <td><?= htmlspecialchars($producto["nombre"]); ?></td>
                                    <td>US$<?= number_format($producto["precio"], 2); ?></td>
                                    <td><?= $producto["cantidad"]; ?></td>
                                    <td>US$<?= number_format($producto["precio"] * $producto["cantidad"], 2); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <p><strong>Total:</strong> US$<?= number_format($total, 2); ?></p>

                    <form action="carrito.php" method="POST">
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
