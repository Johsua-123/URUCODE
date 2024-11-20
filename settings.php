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
    <link rel="shortcut icon" href="public/icons/errea.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/styles/module.css">
    <link rel="stylesheet" href="assets/styles/navbar.css">
    <link rel="stylesheet" href="assets/styles/footer.css">
    <link rel="stylesheet" href="assets/styles/setting.css">
    <script src="assets/scripts/navbar.js"></script>
    <script src="assets/scripts/profile.js"></script>
    <title>Ajustes | Errea</title>
</head>

<body>
    <?php include "reusables/navbar.php"; ?>
    <main>
        <div class="settings">
            <div class="content-section">
                <div class="tab-section">
                    <div id="general" class="tab-body">
                        <h1>Perfil</h1>
                        <?php if (isset($_GET['mensaje'])): ?>
                            <?php if ($_GET['mensaje'] == 'actualizado'): ?>
                                <p class="success-message">Perfil actualizado!</p>
                                <?php endif; ?>
                        <?php endif; ?>

                        <form id="user" method="POST" action="actualizar_perfil.php">
                            <div>
                                <label for="nombre">Nombre</label>
                                <input id="nombre" name="nombre" type="text" value="<?php echo $_SESSION["username"] ?? ""; ?>">
                            </div>
                            <div>
                                <label for="apellido">Apellido</label>
                                <input id="apellido" name="apellido" type="text" value="<?php echo $_SESSION["apellido"] ?? ""; ?>">
                            </div>
                            <div>
                                <label for="email">Correo</label>
                                <input id="email" name="email" type="email" value="<?php echo $_SESSION["email"] ?? ""; ?>" readonly>
                            </div>
                            <div>
                                <label for="telefono">Teléfono</label>
                                <input id="telefono" name="telefono" type="text" value="<?php echo $_SESSION["telefono"] ?? ""; ?>">
                            </div>
                            <div>
                                <label for="ubicacion">Ciudad</label>
                                <input id="ubicacion" name="ubicacion" type="text" value="<?php echo $_SESSION["ubicacion"] ?? ""; ?>">
                            </div>
                            <div>
                                <label for="direccion">Dirección</label>
                                <input id="direccion" name="direccion" type="text" value="<?php echo $_SESSION["direccion"] ?? ""; ?>">
                            </div>
                            <button type="submit">Guardar Cambios</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php include "reusables/footer.php"; ?>
</body>
</html>
