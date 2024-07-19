<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles/module.css">
    <link rel="stylesheet" href="assets/styles/navbar.css">
    <link rel="stylesheet" href="assets/styles/footer.css">
    <link rel="stylesheet" href="assets/styles/contact.css">
    <script src="assets/scripts/navbar.js"></script>
    <title>Contacto | Errea</title>
</head>
<body>
    <?php include 'reusables/navbar.php'; ?>
    <div class="container">
        <form id="contact" class="card" method="POST">
            <div class="card-header">
                <h1>Ponte en contacto con nostros</h1>
            </div>
            <div class="card-items">
                <div>
                    <label for="correo">Nombre</label>
                    <input id="correo" name="correo" type="email" autocomplete="off">
                </div>
                <div>
                    <label for="nombre">Nombre</label>
                    <input id="nombre" name="nombre" type="text" autocomplete="off">
                </div>
                <div>
                    <label for="mensaje">Mensaje</label>
                    <textarea id="mensaje" name="mensaje" cols="30" rows="10" ></textarea>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit">Enviar</button>
            </div>
        </form>
        <div id="modal" class="modal">
            <span id="status"></span>
            <div>
                <button type="button">Acceptar</button>
            </div>
        </div>
    </div>
    <?php include "reusables/footer.php"; ?>
</body>
</html>
