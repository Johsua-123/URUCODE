<?php

    session_start();

    $message = ""; 
    $location = "contacto";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        define("URUCODE", true);
        require "api/mysql.php";

        $email = $_POST['email'];
        $nombre = $_POST['nombre'];
        $asunto = $_POST['asunto'];
        $mensaje = $_POST['mensaje'];
        $fecha = date('Y-m-d H:i:s');

        $stmt = $mysql->prepare("INSERT INTO mensajes (email, nombre, asunto, mensaje, fecha_creacion) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $email,$nombre, $asunto, $mensaje, $fecha);

        if ($stmt->execute()) {
            $message = "Mensaje enviado correctamente."; 
        } else {
            $message = "Error al enviar el mensaje: " . $mysql->error; 
        }
        header("Location: contacto.php?status=success");
        exit();
    }
    

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
    <link rel="shortcut icon" href="public/icons/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/styles/module.css">
    <link rel="stylesheet" href="assets/styles/navbar.css">
    <link rel="stylesheet" href="assets/styles/footer.css">
    <link rel="stylesheet" href="assets/styles/contact.css">
    <script src="assets/scripts/navbar.js"></script>
    <title>Contacto | Errea</title>
</head>
<body>
    <?php include "reusables/navbar.php"; ?>
    <main>
        <div class="contact-wrapper">
            <section class="contact-section">
                <h2>Contáctanos</h2>
                <form method="POST" action="contacto.php">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                    <label for="asunto">Asunto:</label>
                    <input type="text" id="asunto" name="asunto">
                    <label for="mensaje">Mensaje:</label>
                    <textarea id="mensaje" name="mensaje" required></textarea>
                    <button id="enviar" type="submit">Enviar</button>
                </form>
                <?php if (!empty($message)): ?>
                    <p class="message"><?php echo $message; ?></p>
                <?php endif; ?>
            </section>
        </div>
    </main>
    <?php include "reusables/footer.php"; ?>
</body>
</html>
