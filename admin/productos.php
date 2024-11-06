<?php 
    session_start();

    if (!isset($_SESSION["code"])) {
        header("Location: ../index.php");
    }

    $location = "productos";

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
    <script src="assets/scripts/products.js"></script>
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
                        <button type="button" onclick="toggleModal()">Agregar Producto</button>
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
    <div id="productModal" class="modal hidden">
    <div class="modal-content">
        <h2>Agregar Nuevo Producto</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <div>
                <label for="nombre">Nombre del Producto</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div>
                <label for="categoria">Categoría</label>
                <input type="text" id="categoria" name="categoria" required>
            </div>
            <div>
                <label for="icono">Ícono</label>
                <input type="file" id="icono" name="icono" accept=".jpg, .jpeg, .png" required>
            </div>
            <div>
                <label for="stock">Stock</label>
                <input type="number" id="stock" name="stock" required>
            </div>
            <div>
                <label for="marca">Marca</label>
                <input type="text" id="marca" name="marca" required>
            </div>
            <div>
                <label for="modelo">Modelo</label>
                <input type="text" id="modelo" name="modelo" required>
            </div>
            <button type="submit">Guardar Producto</button>
            <button type="button" onclick="toggleModal()">Cerrar</button>
        </form>
    </div>
</div>
</body>
</html>
