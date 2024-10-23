<?php 
    session_start();

    if (!isset($_SESSION["code"])) {
        header("Location: ../index.php");
        exit(); 
    }

    $location = "products";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles/module.css">
    <link rel="stylesheet" href="assets/styles/navbar.css">
    <link rel="stylesheet" href="assets/styles/sidebar.css">
    <link rel="stylesheet" href="assets/styles/products.css">
    <title>Productos | Errea Admin</title>
</head>
<body>
    <?php include "reusables/sidebar.php"; ?>
    <div class="container">
        <?php include "reusables/navbar.php"; ?>
        <main>
            <div class="users-title">
                <h1>Listado de Productos</h1>
            </div>
            <div class="users-table">
                <div class="card">
                    <header>
                        <h2>Productos</h2>
                        <button type="button">
                            Agregar Producto
                        </button>
                    </header>
                    <div class="wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Categoría</th>
                                    <th>Ícono</th>
                                    <th>Stock</th>
                                    <th>Marca</th>
                                    <th>Modelo</th>
                                    <th>Fecha Creación</th>
                                    <th>Fecha Actualización</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="cell-content">Laptop ASUS</span></td>
                                    <td><span class="cell-content">Electrónica</span></td>
                                    <td><img src="ruta/al/icono.png" alt="Icono" class="icon-img"></td>
                                    <td><span class="cell-content">10</span></td>
                                    <td><span class="cell-content">ASUS</span></td>
                                    <td><span class="cell-content">X512</span></td>
                                    <td><span class="cell-content">2023-01-15</span></td>
                                    <td><span class="cell-content">2023-10-15</span></td>
                                    <td>
                                        <button>Editar</button>
                                        <button>Eliminar</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
