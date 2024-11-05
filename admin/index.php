<?php 
    session_start();

    if (!isset($_SESSION["code"])) {
        header("Location: ../index.php");
        exit();
    }

    $location = "index";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles/module.css">
    <link rel="stylesheet" href="assets/styles/navbar.css">
    <link rel="stylesheet" href="assets/styles/sidebar.css">
    <title>Home | Errea Admin</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <?php include "reusables/sidebar.php"; ?>
    <div class="container">
        <?php include "reusables/navbar.php"; ?>
        <main>
            <h1>Gráficas</h1>
            
            <div class="charts-container">
                <div class="chart-wrapper">
                    <h2 class="chart-title">Ventas Mensuales</h2>
                    <canvas id="chart1"></canvas>
                </div>
                <div class="chart-wrapper">
                    <h2 class="chart-title">Usuarios Registrados</h2>
                    <canvas id="chart3"></canvas>
                </div>
                <div class="chart-wrapper">
                    <h2 class="chart-title">Tráfico por Plataforma</h2>
                    <canvas id="chart5"></canvas>
                </div>
            </div>
        </main>
    </div>
    
    <script>
        const createChart = (ctx, type, data, options) => {
            return new Chart(ctx, {
                type: type,
                data: data,
                options: options
            });
        };

        createChart(document.getElementById("chart1"), "bar", {
            labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
            datasets: [{
                label: "Ventas en USD",
                data: [3000, 4000, 3200, 4500, 6000, 8000, 12000, 10000, 8500, 9000, 15000, 20000],
                backgroundColor: "rgba(54, 162, 235, 0.5)",
                borderColor: "rgba(54, 162, 235, 1)",
                borderWidth: 1
            }]
        }, { responsive: true });

        createChart(document.getElementById("chart3"), "line", {
            labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
            datasets: [{
                label: "Usuarios registrados",
                data: [100, 120, 150, 130, 180, 200, 250, 220, 210, 240, 300, 350],
                borderColor: "rgba(75, 192, 192, 1)",
                backgroundColor: "rgba(75, 192, 192, 0.2)",
                fill: true
            }]
        }, { responsive: true });

        createChart(document.getElementById("chart5"), "radar", {
            labels: ["Web", "Móvil", "Redes Sociales", "Correo", "Referencias"],
            datasets: [{
                label: "Tráfico por plataforma",
                data: [80, 90, 70, 50, 60],
                backgroundColor: "rgba(255, 159, 64, 0.2)",
                borderColor: "rgba(255, 159, 64, 1)",
                borderWidth: 1
            }]
        }, { responsive: true });
    </script>
</body>
</html>
