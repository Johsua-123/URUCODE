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
        <link rel="shortcut icon" href="public/icons/logo.png" type="image/x-icon">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="assets/styles/module.css">
        <link rel="stylesheet" href="assets/styles/navbar.css">
        <link rel="stylesheet" href="assets/styles/footer.css">
        <link rel="stylesheet" href="assets/styles/about.css">
        <script src="assets/scripts/navbar.js"></script>
        <title>Sobre Nosotros | Errea</title>
    </head>
    <body>
        <?php include "reusables/navbar.php"; ?>
        <main>
        <div class="about-us">
                <h1>About Us</h1>
                <section>
                    <h2>Company</h2>
                    <p>Name: URUCODE</p>
                    <p>Address: Belen 400, 50000 Salto, Departamento de Salto</p>
                    <p>Phone Number: +598 92 143 086</p>
                    <p>E-Mail: Urucode2024@gmail.com</p>
                    <p>Members: Facundo Bisio, Juan Cruz Pirotto, Johsua Hartwig, Mateo Severo</p>
                </section>
                <section>
                    <h2>Description</h2>
                    <p>
                        Urucode is a software development company specializing in the creation of software and 
                        websites for businesses of all sizes and industries. The company stands out for its 
                        relationships with clients, as well as its creativity and professionalism in the 
                        technological field.
                    </p>
                </section>
                <section>
                    <h2>Mission</h2>
                    <p>
                        Our mission is to drive technological innovation by creating high-quality websites. We are 
                        dedicated to continuous learning and growth, working with passion and creativity to provide 
                        solutions tailored to each client's needs. We focus on customer relationships based on 
                        transparency, efficiency, and trust.
                    </p>
                </section>
                <section>
                    <h2>Vision</h2>
                    <p>
                        We aim to be known for our dedication, innovation, and customer service in web development. 
                        Our dream is to grow together as a team, exploring new technologies and trends, while never 
                        losing sight of our commitment to quality and accessibility.
                    </p>
                </section>
            </div>
            <div class="about-us">
                <h1>Sobre nosotros</h1>
                <section>
                    <h2>Empresa</h2>
                    <p>Nombre: URUCODE</p>
                    <p>Dirección: Belen 400, 50000 Salto, Departamento de Salto</p>
                    <p>Teléfono: +598 92 143 086</p>
                    <p>Correo Eletrónico: Urucode2024@gmail.com</p>
                    <p>Integrantes: Facundo Bisio, Juan Cruz Pirotto, Johsua Hartwig, Mateo Severo</p>
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