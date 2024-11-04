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
                        <button type="button" id="addCategoryBtn">
                            Agregar Categoría
                            
                        </button>
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
    <script src="admin\assets\scripts\categories.js"></script>
</body>
</html>
