
<link rel="stylesheet" href="assets/styles/navbar.css">
<script src="assets/scripts/navbar.js"></script>

<div class="navbar">
    <header>
        <div class="navbar-header">
            <a class="navbar-brand" href="http://localhost/URUCODE/">
                <img src="public/errea-logo.png" alt="logo de errea">
            </a>
            <div class="navbar-search">
                <span>search</span>
            </div>
            <div class="navbar-extras">
                <!-- Imagen de perfil por defecto -->
                <svg id="users-icon" class="users-icon" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"></path>
                </svg>
                <!-- Imagen de perfil del usuario -->
                <img 
                    style="<?php if (!isset($_SESSION["user-icon"])) echo "display: none;"; ?>" 
                    src="<?php if (isset($_SESSION["user-icon"])) echo $_SESSION["user-icon"]; ?>"
                    alt="imagen de perfil"
                >
                <!-- Icono de carrito -->
                <div class="navbar-product">
                    <span id="cart-counter"></span>
                    <svg 
                        id="cart-icon"
                        fill="none" 
                        stroke-width="1.5" 
                        stroke="currentColor" 
                        viewBox="0 0 24 24"
                    >
                        <path 
                            stroke-linecap="round" 
                            stroke-linejoin="round" 
                            d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"
                        >
                        </path>
                    </svg>
                </div>
            </div>
        </div>
    </header>
    <nav>
        <div id="navbar-links" class="navbar-wrapper">
           <a id="home" href="http://localhost/URUCODE/">Inicio</a>
           <a id="store" href="http://localhost/URUCODE/store.php">Tienda</a>
           <a id="contact" href="http://localhost/URUCODE/contact.php">Contáctanos</a>
        </div>
    </nav>
</div>
