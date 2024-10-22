
<header class="navbar">
    <div>
        <div class="navbar-brand">
            <a href="index.php">
                <img src="../public/icons/errea.png" alt="logo de errea">
            </a>
        </div>
        <div class="navbar-route">
            <span> /admin/path </span>
        </div>
        <div class="navbar-extra">
            <svg class="navbar-toggler" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"></path>
            </svg>
            <div class="navbar-profile">
                <img class="<?php echo !(isset($_SESSION["code"]) && isset($_SESSION["image"])) ? "hidden" : "" ?>" src="<?php $_SESSION["image"] ?? "" ?>" alt="user image">
                <img class="<?php echo !(isset($_SESSION["code"]) && isset($_SESSION["image"])) ? "hidden" : "" ?>" src="<?php echo isset($_SESSION["image"]) ?? "" ?>" alt="imagen de perfil">
            </div>
        </div>
    </div>
</header>