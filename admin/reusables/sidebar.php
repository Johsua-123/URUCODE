<?php
// Obtener información del usuario autenticado
$stmt = $mysql->prepare("SELECT rol FROM usuarios WHERE codigo = ?");
$stmt->bind_param("s", $_SESSION["code"]);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$rol = $user["rol"] ?? null;
$stmt->close();
?>
<aside class="sidebar">
    <header>
        <a href="http://localhost/URUCODE/admin">
            <img src="../public/icons/errea.png" alt="logo de errea">
            <h1>Errea</h1>
        </a>
    </header>
    <footer>
        <!-- Visible para todos -->
        <a href="index.php" class="<?php echo $location == "inicio" ? "sidebar-active" : "" ?>">Inicio</a>
        <a href="tienda.php" class="<?php echo $location == "tienda" ? "sidebar-active" : "" ?>">Tienda</a>

        <!-- Visible solo para dueño y supervisor -->
        <?php if ($rol === "dueño" || $rol === "supervisor"): ?>
            <a href="ventas.php" class="<?php echo $location == "ventas" ? "sidebar-active" : "" ?>">Ventas</a>
            <a href="cuentas.php" class="<?php echo $location == "cuentas" ? "sidebar-active" : "" ?>">Cuentas</a>
        <?php endif; ?>

        <!-- Visible para dueño, supervisor y admin -->
        <?php if ($rol === "dueño" || $rol === "supervisor" || $rol === "admin"): ?>
            <a href="inventario.php" class="<?php echo $location == "inventario" ? "sidebar-active" : "" ?>">Inventario</a>
            <a href="categorias.php" class="<?php echo $location == "categorias" ? "sidebar-active" : "" ?>">Categorías</a>
        <?php endif; ?>

        <!-- Visible para todos -->
        <a href="mensajes.php" class="<?php echo $location == "mensajes" ? "sidebar-active" : "" ?>">Mensajes</a>
    </footer>
</aside>
