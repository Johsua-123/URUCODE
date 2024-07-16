<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contáctanos | Errea</title>
    <link rel="stylesheet" href="assets/styles/estilos.css">
</head>
<body>
<?php include 'reusables/navbar.php';
?>
    <div class="contact-container">
        <div class="contact-form">
            <h2>Contáctanos</h2>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
                $nombre = $_POST['nombre'];
                $asunto = $_POST['asunto'];
                $correo = $_POST['correo'];
                $mensaje = $_POST['mensaje'];


                $destinatario = "juancruzpirotto0805@gmail.com";
                $cabeceras = "De: " . $correo . "\r\n";
                $mensajeCompleto = "Nombre: " . $nombre . "\nCorreo: " . $correo . "\n\nMensaje:\n" . $mensaje;

                if (mail($destinatario, $asunto, $mensajeCompleto, $cabeceras)) {
                    echo "<p style='color: green;'>Mensaje enviado exitosamente.</p>";
                } else {
                    echo "<p style='color: red;'>Error al enviar el mensaje.</p>";
                }
            }
            ?>

            <form action="contact.php" method="POST">
                <input type="text" name="nombre" placeholder="Nombre" required>
                <input type="text" name="asunto" placeholder="Asunto" required>
                <input type="email" name="correo" placeholder="Correo electrónico" required>
                <textarea name="mensaje" rows="5" placeholder="Mensaje" required></textarea>
                <button type="submit">Enviar</button>
            </form>
        </div>
    </div>
</body>
</html>
