<?php
session_start();

if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = []; 
}

if (count($_SESSION['cart']) === 0) {
    echo "<p>No hay productos en el carrito.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito | Errea</title>
    <link rel="stylesheet" href="assets/styles/module.css">
    <link rel="stylesheet" href="assets/styles/navbar.css">
    <link rel="stylesheet" href="admin/assets/styles/products.css">
</head>
<body>
    <?php include "reusables/navbar.php"; ?>

                    </header>
                    <table class="accounts-table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Ícono</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total = 0;
                            foreach ($_SESSION['cart'] as $item) {
                                // Verificar que $item sea un array antes de intentar acceder a sus índices
                                if (!is_array($item)) {
                                    continue; // Saltar si $item no es un array
                                }

                                // Convertir precio y cantidad a números
                                $precio = isset($item['precio']) ? (float)$item['precio'] : 0;
                                $cantidad = isset($item['cantidad']) ? (int)$item['cantidad'] : 1;

                                // Calcular subtotal
                                $subtotal = $precio * $cantidad;
                                $total += $subtotal;
                            ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($item['nombre']); ?></td>
                                    <td>
                                        <?php if (!empty($item['imagen_url'])) { ?>
                                            <img src="<?php echo htmlspecialchars($item['imagen_url']); ?>" alt="Ícono" width="50">
                                        <?php } else { ?>
                                            No disponible
                                        <?php } ?>
                                    </td>
                                    <td>US$<?php echo number_format($precio, 2); ?></td>
                                    <td>
                                        <input type="number" value="<?php echo $cantidad; ?>" min="1" style="width: 50px; text-align: center;">
                                    </td>
                                    <td>US$<?php echo number_format($subtotal, 2); ?></td>
                                    <td>
                                        <form method="post" action="remove_from_cart.php">
                                            <input type="hidden" name="codigo" value="<?php echo htmlspecialchars($item['codigo']); ?>">
                                            <button type="submit" class="delete-button">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" style="text-align: right;"><strong>Total:</strong></td>
                                <td colspan="2">US$<?php echo number_format($total, 2); ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div>
                    <button onclick="location.href='checkout.php'" class="btn btn-primary btn-lg">Finalizar compra</button>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
