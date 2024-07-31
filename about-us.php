<?php 
    session_start();
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <link rel="shortcut icon" href="public/errea-logo.png" type="image/x-icon">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="assets/styles/module.css">
        <link rel="stylesheet" href="assets/styles/navbar.css">
        <link rel="stylesheet" href="assets/styles/footer.css">
        <link rel="stylesheet" href="assets/styles/about-us.css">
        <script src="https://kit.fontawesome.com/eb496ab1a0.js"></script>
        <title>Sobre Nosotros | Errea</title>
    </head>

    <body>
        <?php include "reusables/navbar.php"; ?>
        <main>
            <div class="about-us">
                <h1>Acerca de nostros</h1>
                <section>
                    <h2>Empresa</h2>
                    <p>Nombre: URUCODE</p>
                    <p>Dirección: Belen 400, 50000 Salto, Departamento de Salto</p>
                    <p>Teléfono: +598 92 143 086</p>
                    <p>Correo Eletrónico: Urucode2024@gmail.com</p>
                    <p>Integrantes: Juan Cruz Pirotto, Johsua Hartwig, Mateo Severo, Facundo Bisio</p>
                </section>
                <section>
                    <h2>Descripción</h2>
                    <p>
                        Urucode es una empresa de desarrollo de software que se especializa en la creación 
                        de software y páginas web para empresas de todos los tamaños y rubros, se destaca 
                        por sus relaciones con sus clientes además de su creatividad y profesionalismo en 
                        el ámbito tecnológico.
                    </p>
                </section>
                <section>
                    <h2>Misión</h2>
                    <p>Nuestra misión es impulsar la innovación tecnológica mediante la creación de páginas 
                        web de alta calidad. Nos dedicamos a aprender y crecer continuamente, trabajando con 
                        pasión y creatividad para ofrecer soluciones que se adapten a las necesidades de cada 
                        cliente. Nos enfocamos en la relación con el cliente basándose en la transparencia, 
                        eficiencia y confianza.
                    </p>
                </section>
                <section>
                    <h2>Visión</h2>
                    <p>
                        Queremos ser conocidos por nuestra dedicación, innovación y atención al cliente en el 
                        desarrollo de páginas web. Nuestro sueño es crecer juntos como equipo, explorando nuevas 
                        tecnologías y tendencias, sin perder nunca de vista nuestro compromiso con la calidad 
                        y la accesibilidad.
                    </p>
                </section>
            </div>
        </main>
        <?php include "reusables/footer.php"; ?>
    </body>
</html>