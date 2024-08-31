
<header class="navbar">
    <div class="navbar-header">
        <a class="navbar-brand" href="index.php">
            <img src="public/icons/errea.png" alt="errea icon">
        </a>
        <div class="navbar-search">
            <form id="search" method="POST">
                <input type="text" name="search" placeholder="Buscar" autocomplete="off">
                <button type="submit">
                    <svg fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"></path>
                    </svg>
                </button>
            </form>
        </div>
        <div class="navbar-extras">
            <div class="navbar-auth" style="<?php echo isset($_SESSION["code"]) ? "display: none" : "display: flex"; ?>">
                <a href="signin.php">Iniciar</a>
                <a href="signup.php">Registrar</a>
            </div>
            <!-- Dropdown del perfil
            <div id="dropdown-1" class="profile-dropdown">
                <a href="setting.php">Ajustes</a>
                <a href="logout.php">Salir</a>
            </div>
            -->
            <!-- icono de perfil de usuario -->
            <svg id="profile-1" style="<?php echo (isset($_SESSION["code"]) && !isset($_SESSION["image"])) ? "display: block" : "display: none" ?>" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"></path>
            </svg>
            <!-- imagen perfil del usuario -->
            <img id="profile-2" style="<?php echo !(isset($_SESSION["code"]) && isset($_SESSION["image"])) ? "display: none" : "display: block" ?>" src="<?php $_SESSION["image"] ?? "" ?>" alt="user image">
            <!-- Icono de apertura del sidebar mobile -->
            <svg id="navbar" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"></path>
            </svg>
            <div id="cart-section" class="navbar-product">
                <svg fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312"/>
                </svg>
                <span id="cart-counts">0</span>
            </div>
        </div>
    </div>
    <div class="navbar-footer">
        <div class="navbar-category dropdown">
            <svg class="category" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"></path>
            </svg>
            <span>Categorias</span>
            <div id="" class="dropdown-menu hidden">

            </div>
        </div>
        <div class="navbar-links">
            <a href="index.php" class="<?php echo $location == "index" ? "navbar-active" : "" ?>">
                <svg fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"></path>
                </svg>
                <span>Inicio</span>
            </a>
            <a href="store.php" class="<?php echo $location == "store" ? "navbar-active" : "" ?>">
                <svg fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"></p>
                </svg>
                <span href="store.php">Tienda</span>
            </a>
            <a href="contact.php" class="<?php echo $location == "contact" ? "navbar-active" : "" ?>">
                <svg fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"></p>
                </svg>
                <span href="contact.php">Contacto</span>
            </a>
        </div>
    </div>
    <!-- Diseño mobile -->
    <div id="sidebar">
        <div class="navbar-search">
            <form id="search-mobile" method="POST">
                <input type="text" name="search" placeholder="Buscar" autocomplete="off">
                <button type="submit">
                    <svg fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"></path>
                    </svg>
                </button>
            </form>
        </div>
        <div class="navbar-links">
            <a href="index.php" class="<?php echo $location == "index" ? "navbar-active" : "" ?>">
                <svg fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"></path>
                </svg>
                <span>Inicio</span>
            </a>
            <a href="store.php" class="<?php echo $location == "store" ? "navbar-active" : "" ?>">
                <svg fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"></p>
                </svg>
                <span>Tienda</span>
            </a>
            <a href="contact.php" class="<?php echo $location == "contact" ? "navbar-active" : "" ?>">
                <svg fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"></p>
                </svg>
                <span>Contacto</span>
            </a>
        </div>
    </div>
    
</header>