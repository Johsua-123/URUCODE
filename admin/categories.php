<?php 
    session_start();

    if (!isset($_SESSION["code"])) {
        header("Location: ../index.php");
        exit();
    }

    $location = "categories";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles/module.css">
    <link rel="stylesheet" href="assets/styles/navbar.css">
    <link rel="stylesheet" href="assets/styles/sidebar.css">
    <link rel="stylesheet" href="assets/styles/categories.css">
    <script src="assets/scripts/categories.js"></script>
    <title>Categorías | Errea Admin</title>
</head>
<body>
    <?php include "reusables/sidebar.php"; ?>
    <div class="container">
        <?php include "reusables/navbar.php"; ?>
        <main>
            <div class="users-title">
                <h1>Listado de Categorías</h1>
            </div>
            <div class="users-table">
                <div class="card">
                    <header>
                        <h2>Categorías</h2>
                        <button type="button" id="addCategoryBtn" onclick="toggleModal()">Agregar Categoría</button>
                    </header>
                    <div class="wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Sub Categoría</th>
                                    <th>Ícono</th>
                                    <th>Fecha Creación</th>
                                    <th>Fecha Actualización</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="categoryTableBody">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <div id="productModal" class="modal hidden">
    <div class="modal-content">
        <h2>Agregar Nueva Categoría</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <div>
                <label for="nombre">Nombre de la Categoría</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div>
                <label for="categoria">Subcategoría</label>
                <input type="text" id="categoria" name="categoria" required>
            </div>
            <div>
                <label for="icono">Ícono</label>
                <input type="file" id="icono" name="icono" accept=".jpg, .jpeg, .png" required>
            </div>
            <button type="submit">Guardar Producto</button>
            <button type="button" onclick="toggleModal()">Cerrar</button>
        </form>
    </div>
</div>

</body>
</html>
