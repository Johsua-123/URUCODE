<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_POST['codigo'])) {
    $product_code = $_POST['codigo'];

    if (isset($_SESSION['cart'][$product_code])) {
        $_SESSION['cart'][$product_code]++;
    } else {
        $_SESSION['cart'][$product_code] = 1;
    }

    // Obtener detalles del producto para actualizar la lista del carrito
    require 'mysql.php';
    $stmt = $mysql->prepare("SELECT * FROM productos WHERE codigo = ?");
    $stmt->bind_param("i", $product_code);
    $stmt->execute();
    $result = $stmt->get_result();
    $producto = $result->fetch_assoc();

    $cartItemsHtml = '';
    foreach ($_SESSION['cart'] as $codigo => $cantidad) {
        $stmt = $mysql->prepare("SELECT * FROM productos WHERE codigo = ?");
        $stmt->bind_param("i", $codigo);
        $stmt->execute();
        $result = $stmt->get_result();
        $producto = $result->fetch_assoc();
        $cartItemsHtml .= '<div class="cart-item">';
        $cartItemsHtml .= '<p>' . htmlspecialchars($producto['nombre']) . ' x ' . $cantidad . '</p>';
        $cartItemsHtml .= '</div>';
    }

    $totalItems = array_sum($_SESSION['cart']);

    echo json_encode(['totalItems' => $totalItems, 'cartItemsHtml' => $cartItemsHtml]);
}
?>
