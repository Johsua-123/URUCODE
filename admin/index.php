<?php
session_start();

require '../api/mysql.php';

//actividad de usuarios por fecha
$stmtUsuarios = $mysql->prepare("
    SELECT DATE(fecha_creacion) AS fecha, COUNT(*) AS cantidad
    FROM usuarios
    GROUP BY DATE(fecha_creacion)
    ORDER BY fecha ASC
");
$stmtUsuarios->execute();
$resultadoUsuarios = $stmtUsuarios->get_result();
$actividadesUsuarios = [];

while ($fila = $resultadoUsuarios->fetch_assoc()) {
    $actividadesUsuarios[] = $fila;
}

// Formatear datos para Chart.js
$fechasUsuarios = array_map(fn($a) => $a['fecha'], $actividadesUsuarios);
$cantidadesUsuarios = array_map(fn($a) => $a['cantidad'], $actividadesUsuarios);

// Consulta para obtener actividad de ordene
$stmtOrdenes = $mysql->prepare("
    SELECT DATE(fecha_creacion) AS fecha, COUNT(*) AS cantidad
    FROM ordenes
    GROUP BY DATE(fecha_creacion)
    ORDER BY fecha ASC
");
$stmtOrdenes->execute();
$resultadoOrdenes = $stmtOrdenes->get_result();
$actividadesOrdenes = [];

while ($fila = $resultadoOrdenes->fetch_assoc()) {
    $actividadesOrdenes[] = $fila;
}

// Formatear datos para Chart.js
$fechasOrdenes = array_map(fn($o) => $o['fecha'], $actividadesOrdenes);
$cantidadesOrdenes = array_map(fn($o) => $o['cantidad'], $actividadesOrdenes);

// Consulta para obtener categorías con más productos
$stmtCategorias = $mysql->prepare("
    SELECT c.nombre AS categoria, COUNT(pc.producto_id) AS cantidad
    FROM categorias c
    LEFT JOIN productos_categorias pc ON c.codigo = pc.categoria_id
    GROUP BY c.codigo, c.nombre
    ORDER BY cantidad DESC
");
$stmtCategorias->execute();
$resultadoCategorias = $stmtCategorias->get_result();
$categoriasProductos = [];

while ($fila = $resultadoCategorias->fetch_assoc()) {
    $categoriasProductos[] = $fila;
}

$nombresCategorias = array_map(fn($c) => $c['categoria'], $categoriasProductos);
$cantidadesCategorias = array_map(fn($c) => $c['cantidad'], $categoriasProductos);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../public/icons/errea.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/styles/module.css">
    <link rel="stylesheet" href="assets/styles/navbar.css">
    <link rel="stylesheet" href="assets/styles/sidebar.css">
    <link rel="stylesheet" href="assets/styles/graficas.css">
    <title>Dashboard | Errea</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <?php include "reusables/sidebar.php"; ?>
    <?php include "reusables/navbar.php"; ?>

    <main>
        <div class="container">
            <section class="section">
                <div class="box full-width">
                    <h2>Usuarios Registrados por Fecha</h2>
                    <canvas id="usuariosChart"></canvas>
                </div>
                <div class="box full-width">
                    <h2>Órdenes Registradas por Fecha</h2>
                    <canvas id="ordenesChart"></canvas>
                </div>
                <div class="box full-width">
                    <h2>Productos por Categoría</h2>
                    <canvas id="categoriasChart"></canvas>
                </div>
            </section>
        </div>
    </main>

    <script>
        
        const dataUsuarios = {
            labels: <?php echo json_encode($fechasUsuarios); ?>,
            datasets: [{
                label: 'Usuarios registrados por fecha',
                data: <?php echo json_encode($cantidadesUsuarios); ?>,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        };

        const configUsuarios = {
            type: 'bar',
            data: dataUsuarios,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        const usuariosChart = new Chart(
            document.getElementById('usuariosChart'),
            configUsuarios
        );

        const dataOrdenes = {
            labels: <?php echo json_encode($fechasOrdenes); ?>,
            datasets: [{
                label: 'Órdenes registradas por fecha',
                data: <?php echo json_encode($cantidadesOrdenes); ?>,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        };

        const configOrdenes = {
            type: 'line',
            data: dataOrdenes,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        const ordenesChart = new Chart(
            document.getElementById('ordenesChart'),
            configOrdenes
        );

        const dataCategorias = {
            labels: <?php echo json_encode($nombresCategorias); ?>,
            datasets: [{
                label: 'Productos por categoría',
                data: <?php echo json_encode($cantidadesCategorias); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        };

        const configCategorias = {
            type: 'bar',
            data: dataCategorias,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        const categoriasChart = new Chart(
            document.getElementById('categoriasChart'),
            configCategorias
        );
    </script>
</body>
</html>
