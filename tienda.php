<?php 

    session_start();

    $location = "tienda";

    require "api/mysql.php";

    $stmt = $mysql->prepare("SELECT * FROM categorias WHERE eliminado=false");
    $stmt->execute();
    $categorias = $stmt->get_result();

    $order = $_GET["order"] ?? null;
    $query = $_GET["query"] ?? null;

   if (!empty($query)) {
    
        $orden = "ASC";

        if (!empty($order) && $order == "precioAltoBajo") {
            $orden = "DESC";
        }

        // consulta
        $stmt = $mysql->prepare("SELECT 
            p.*
            FROM productos p
            LEFT JOIN imagenes i ON productos.imagen_id=i.codigo
            WHERE p.en_venta=true AND p.eliminado=false
            AND (p.nombre LIKE ? OR p.modelo LIKE ? OR p.marca LIKE ? OR p.descripcion LIKE ?)
            ORDER BY $orden
        ");

        $busqueda = "%$query%";
        $stmt->bind_param("ssss", $busqueda, $busqueda, $busqueda, $busqueda);

        $stmt->execute();
        $resultado = $stmt->get_result();

        $productos = [];

        while ($producto = $resultado->fetch_assoc()) {
            $imagen = $producto["i.nombre"] . "-" . $producto["i.codigo"] . $producto["i.extension"];
            $producto["imagen"] = file_exists("public/images/$imagen") ? "public/images/$imagen" : "public/images/imagen-vacia.png";
            unset($producto["i.codigo"], $producto["i.nombre"], $producto["i.extension"]);
            $productos[] = $producto;
        }

   }

?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-DF773N72G0"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag("js", new Date());
            gtag("config", "G-DF773N72G0");
        </script>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="public/icons/errea.png" type="image/x-icon">
        <link rel="stylesheet" href="assets/styles/module.css">
        <link rel="stylesheet" href="assets/styles/navbar.css">
        <link rel="stylesheet" href="assets/styles/footer.css">
        <link rel="stylesheet" href="assets/styles/tienda.css">
        <script src="assets/scripts/navbar.js"></script>
        <title>Tienda | Errea</title>
    </head>
    <body>
    <?php include "reusables/navbar.php"; ?>
        <main>
            <div class="sidebar">
                <h2>Todas las Categorías</h2>
                <ul class="category-list-shop">
                    <?php while ($categoria = $categorias->fetch_assoc()) { ?>
                        <li>
                            <a href="visualizar.php?producto=<?php echo $categoria["codigo"]; ?>"><?php echo $categoria["nombre"]; ?></a>
                        </li>
                    <?php } ?>
                </ul>
            </div>

            <div class="filter-bar">
                <form method="GET" action="tienda.php">
                    <label for="ordenar">Ordenar por:</label>
                    <select id="ordenar" name="order" onchange="this.form.submit()">
                        <option value="precioBajoAlto" <?php echo $orden == "precioBajoAlto" ? "selected" : ""; ?>>Precio: Bajo a Alto</option>
                        <option value="precioAltoBajo" <?php echo $orden == "precioAltoBajo" ? "selected" : ""; ?>>Precio: Alto a Bajo</option>
                    </select>
                    <input type="hidden" name="query" value="<?php echo $_GET["query"] ?? ""; ?>">
                </form>
            </div>

            <div class="main-products">
                <div class="product-items">

                </div>
                <div class="pagination">
                </div>
            </div>
        </main>
        <?php include "reusables/footer.php" ?>
    </body>
</html>